<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[AppEnquiryProducts]].
 *
 * @see AppEnquiryProducts
 */
class AppEnquiryProductsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return AppEnquiryProducts[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return AppEnquiryProducts|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
