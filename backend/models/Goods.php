<?php

namespace backend\models;

use common\components\cart\GoodsInterface;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Goods as GoodsModel;

/**
 * Goods represents the model behind the search form about `common\models\Goods`.
 */
class Goods extends GoodsModel implements GoodsInterface
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'price'], 'integer'],
            [['name'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = GoodsModel::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 15,
            ],
            'sort' => [
                'defaultOrder' => [
                    'id'=> SORT_DESC
                ]
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'price' => $this->price,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }

    private $_quantity = 0;
    public function getPrice(): int
    {
        return $this->price;
    }
    public function getKey(): string
    {
        return $this->id;
    }
    public function setQuantity(int $quantity)
    {
        $this->_quantity = $quantity;
    }
    public function getQuantity(): int
    {
        return $this->_quantity;
    }
    public function getCost(): int
    {
        return $this->getPrice() * $this->getQuantity();
    }
}
