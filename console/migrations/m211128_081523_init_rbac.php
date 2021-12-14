<?php

use yii\db\Migration;

/**
 * Class m211128_081523_init_rbac
 */
class m211128_081523_init_rbac extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        // add "createPost" permission
        /*$createPost = $auth->createPermission('createPost');
        $createPost->description = 'Create a post';
        $auth->add($createPost);*/

        // add "updatePost" permission
        /*$updatePost = $auth->createPermission('updatePost');
        $updatePost->description = 'Update post';
        $auth->add($updatePost);*/

        $listProduct = $auth->createPermission('product/index');
        $listProduct->description = 'Product List';
        $auth->add($listProduct);
        
        $viewProduct = $auth->createPermission('product');
        $viewProduct->description = 'Product View';
        $auth->add($viewProduct);

        $createProduct = $auth->createPermission('product/create');
        $createProduct->description = 'Product Create';
        $auth->add($createProduct);

        $updateProduct = $auth->createPermission('product/update');
        $updateProduct->description = 'Product Update';
        $auth->add($updateProduct);
        
        $deleteProduct = $auth->createPermission('product/delete');
        $deleteProduct->description = 'Product Delete';
        $auth->add($deleteProduct);

        // add "customer" role and give this role the "createPost" permission
        $customer = $auth->createRole('customer');
        $auth->add($customer);
        $auth->addChild($customer, $listProduct);
        $auth->addChild($customer, $viewProduct);

        // add "admin" role and give this role the "updatePost" permission
        // as well as the permissions of the "customer" role
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $createProduct);
        $auth->addChild($admin, $updateProduct);
        $auth->addChild($admin, $deleteProduct);
        $auth->addChild($admin, $customer);

        // Assign roles to users. 1 and 2 are IDs returned by IdentityInterface::getId()
        // usually implemented in your User model.
        /*$auth->assign($customer, 2);
        $auth->assign($admin, 1);*/

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m211128_081523_init_rbac cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211128_081523_init_rbac cannot be reverted.\n";

        return false;
    }
    */
}
