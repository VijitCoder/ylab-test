<?php
namespace app\widgets;

use app\models\ProductSummarySearch;
use yii\data\ActiveDataProvider;
use yii\grid\Column;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Added logic for row spans in grouped field.
 */
class SpanGridView extends GridView
{
    /**
     * @var ProductSummarySearch
     */
    public $filterModel;

    /**
     * Value of current grouping rows 
     *
     * @var string
     */
    private $currentGroup;

    /**
     * Row spans for each group of records
     *
     * @var array
     */
    private $rowSpans;

    public function init()
    {
        parent::init();
        $this->rowSpans = $this->calcRowSpans($this->dataProvider, $this->filterModel->groupAttribute);
    }

    /**
     * Calculate row spans in accordance of grouped attribute.
     *
     * @param ActiveDataProvider $dataProvider
     * @param string             $groupAttrName name of attribute associated with "groupBy" selection in the form.
     * @return array
     */
    private function calcRowSpans(ActiveDataProvider $dataProvider, string $groupAttrName): array
    {
        $models = $dataProvider->getModels();
        $groups = [];
        foreach ($models as $index => $model) {
            $attrValue = ArrayHelper::getValue($model, $groupAttrName);
            $groups[$attrValue][] = $index;
        }
        return array_map('count', $groups);
    }

    /**
     * Renders a table row with the given data model and key.
     * 
     * Override parent method with extended logic: rows spanning.
     * 
     * @param mixed $model the data model to be rendered
     * @param mixed $key   the key associated with the data model
     * @param int   $index the zero-based index of the data model among the model array returned by [[dataProvider]].
     * @return string the rendering result
     */
    public function renderTableRow($model, $key, $index)
    {
        $groupAttribute = $this->filterModel->groupAttribute;
        $group = ArrayHelper::getValue($model, $groupAttribute);

        $cells = [];
        /* @var $column Column */
        foreach ($this->columns as $column) {
            if ($column->attribute == $groupAttribute) {

                if ($group == $this->currentGroup) {
                    continue;
                }
                $this->currentGroup = $group;
                
                $rowSpan = $this->rowSpans[$group];

                $options = $this->defineOptions($column->contentOptions, $model, $key, $index);
                $options['rowspan'] = $rowSpan;
                $column->contentOptions = $options;
            }

            $cells[] = $column->renderDataCell($model, $key, $index);
        }

        $options = $this->defineOptions($this->rowOptions, $model, $key, $index);
        $options['data-key'] = is_array($key) ? json_encode($key) : (string)$key;

        return Html::tag('tr', implode('', $cells), $options);
    }

    /**
     * Define options. If it is a Closure, evaluate the function. Otherwise just return $options as it is.
     *
     * @param array|Closure $options
     * @param mixed         $model the data model to be rendered
     * @param mixed         $key   the key associated with the data model
     * @param int           $index the zero-based index of the data model among the model array returned
     *                             by [[dataProvider]].
     * @return array
     */
    private function defineOptions($options, $model, $key, int $index): array
    {
        return $options instanceof Closure ?
            call_user_func($options, $model, $key, $index, $this)
            : $options;
    }
}
