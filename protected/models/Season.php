<?php

/**
 * This is the model class for table "season".
 *
 * The followings are the available columns in table 'season':
 * @property integer $season_id
 * @property string $title
 * @property string $status
 *
 * The followings are the available model relations:
 * @property Week[] $weeks
 */
class Season extends CActiveRecord
{
	const STATUS_ACTIVE 		=	'active';
	const STATUS_COMPLETED 		=	'completed';

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'season';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title', 'length', 'max'=>255),
			array('status', 'length', 'max'=>9),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'weeks' => array(self::HAS_MANY, 'Week', 'season_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'season_id' => 'Season',
			'title' => 'Title',
			'status' => 'Status',
		);
	}

	public function scopes()
    {
        return array(
            'lastOne'=>array(
                'order'=>'season_id DESC',
                'limit'=>1,
            ),
        );
    }

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('season_id',$this->season_id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('status',$this->status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Season the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getAll()
	{
		return Season::model()->findAll();
	}

	public function isExists()
	{
		return Season::model()->exists();
	}

	public function isExistsBySeasonId($seasonId)
	{
		$condition 	=	'season_id=:season_id';
		$param 		=	array(':season_id'=>$seasonId);

		$isExists 	=	Season::model()->exists($condition, $param);

		return $isExists;
	}

	public function getBySeasonId($seasonId)
	{
		$data 	=	Season::model()->findByPk($seasonId);

		return $data;
	}

	public function getActiveSeason()
	{
		$conditions 	= 	'season_id=:season_id AND status=:status';
		$params 		= 	array(':season_id' => $seasonId, ':status' => self::STATUS_ACTIVE);

		$data 	=	Season::model()->find($conditions, $params);

		return $data;
	}

	public function createNewSeason($lastSeasonId)
	{
		$newSeasonId 	= 	$lastSeasonId+1;

		$season 			=	new Season;
		$season->title 		=	'Season: ' . $newSeasonId;
		$season->save();

		return $season->season_id;
	}

	public function completeSeason($seasonId)
	{
		$attributes 	= 	array('status' => self::STATUS_COMPLETED);
		$conditions 	= 	'season_id=:season_id AND status=:status';
		$params 		= 	array(':season_id' => $seasonId, ':status' => self::STATUS_ACTIVE);

		Season::model()->updateAll($attributes, $conditions, $params);
	}

	public function getLastCompletedSeason()
	{
		$conditions  	= 	'status=:status';
		$params 		= 	array(':status' => self::STATUS_COMPLETED);
		$data 			=	Season::model()->lastOne()->find($conditions, $params);

		return $data;
	}
}
