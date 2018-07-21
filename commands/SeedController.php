<?php
namespace app\commands;

use app\models\Category;
use app\models\Product;
use app\models\Provider;
use Yii;
use yii\base\Module;
use yii\console\Controller;
use yii\console\ExitCode;

/**
 * Seeding database with Faker
 *
 * Note: products bounds only to categories/providers which seeded in the current action. But it is possible to change
 * this behavior (not implemented). 
 * 
 * Quantity of each entity hardcoded - 20. It is not good, but enough for test job. 
 */
class SeedController extends Controller
{
    private $faker;

    public function __construct(string $id, Module $module, array $config = [])
    {
        $this->faker = \Faker\Factory::create(); // 'ru_RU'
        parent::__construct($id, $module, $config);
    }

    /**
     * Seed all tables at once. See possible keys in the function signature.
     *
     * @param bool $cleanup       need to cleanup tables before seeding
     * @return int Exit code
     */
    public function actionIndex($cleanup = true)
    {
        if ($cleanup) {
            $this->cleanup();
        }

        $categoriesIds = $this->seedCategories(20);
        $providersIds = $this->seedProviders(20);
        $this->seedProducts(20, $categoriesIds, $providersIds);

        return ExitCode::OK . PHP_EOL;
    }

    /**
     * Truncate tables, which will be seeded
     */
    private function cleanup(): void
    {
        // This doesn't work, MySQL ignores FK switch. 

        //$cmd = Yii::$app->db->createCommand();
        //$cmd->execute('SET FOREIGN_KEY_CHECKS=0');
        //$cmd->truncateTable(Product::tableName())->execute();
        //$cmd->truncateTable(Category::tableName())->execute();
        //$cmd->truncateTable(Provider::tableName())->execute();
        //$cmd->execute('SET FOREIGN_KEY_CHECKS=1');

        Product::deleteAll();
        Category::deleteAll();
        Provider::deleteAll();
    }

    /**
     * Seed categories
     *
     * @param int $qty records quantity
     * @return array
     */
    private function seedCategories(int $qty): array
    {
        $category = new Category;
        $ids = [];
        for ($i = 0; $i < $qty; $i++) {
            $category->setIsNewRecord(true);
            $category->id = null;
            $category->title = $this->faker->word;
            $category->description = $this->faker->sentence;
            $category->sequence = $i;
            $category->save();
            $ids[] = $category->id;
        }
        return $ids;
    }

    /**
     * Seed providers
     *
     * @param int $qty records quantity
     * @return array
     */
    private function seedProviders(int $qty): array
    {
        $provider = new Provider;
        $ids = [];
        for ($i = 0; $i < $qty; $i++) {
            $provider->setIsNewRecord(true);
            $provider->id = null;
            $provider->title = $this->faker->company;
            $provider->sequence = $i;
            $provider->save();
            $ids[] = $provider->id;
        }
        return $ids;
    }

    /**
     * Seed products
     *
     * @param int   $qty           records quantity
     * @param array $categoriesIds available categories
     * @param array $providersIds  available providers
     * @return array
     */
    private function seedProducts(int $qty, array $categoriesIds, array $providersIds): array
    {
        $product = new Product;
        $ids = [];
        for ($i = 0; $i < $qty; $i++) {
            $product->setIsNewRecord(true);
            $product->id = null;
            $product->title = $this->faker->word;
            $product->description = $this->faker->sentence;
            $product->price = $this->faker->randomFloat(2,1,999);
            $product->image = $this->faker->imageUrl($width = 640, $height = 480);
            $product->category_id = $this->faker->randomElement($categoriesIds);
            $product->provider_id = $this->faker->randomElement($providersIds);
            $product->save();
            $ids[] = $product->id;
        }
        return $ids;
    }
}
