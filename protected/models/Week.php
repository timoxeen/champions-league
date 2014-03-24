<?php

/**
 * This is the model class for table "week".
 *
 * The followings are the available columns in table 'week':
 * @property integer $week_id
 * @property integer $season_id
 * @property string $title
 * @property string $status
 *
 * The followings are the available model relations:
 * @property Fixture[] $fixtures
 * @property LeagueTable[] $leagueTables
 * @property Season $season
 */
class Week extends CActiveRecord
{
	const STATUS_NOT_COMPLETED 	=	'not-completed';
	const STATUS_COMPLETED 		=	'completed';

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'week';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('season_id', 'required'),
			array('season_id', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>255),
			array('status', 'length', 'max'=>13),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('week_id, season_id, title, status', 'safe', 'on'=>'search'),
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
			'fixtures' => array(self::HAS_MANY, 'Fixture', 'week_id'),
			'leagueTables' => array(self::HAS_MANY, 'LeagueTable', 'week_id'),
			'leagueTablesOrdered' => array(self::HAS_MANY, 'LeagueTable', 'week_id',
					'order' => 'points DESC, goal_difference DESC'),
			'season' => array(self::BELONGS_TO, 'Season', 'season_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'week_id' => 'Week',
			'season_id' => 'Season',
			'title' => 'Title',
			'status' => 'Status',
		);
	}

	public function scopes()
    {
        return array(
            'lastOne'=>array(
            	'select'=>array('week_id'),
                'order'=>'week_id DESC',
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

		$criteria->compare('week_id',$this->week_id);
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
	 * @return Week the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function createSeasonAllWeekBySeasonId($seasonId)
	{
		$teamCount 	=	Team::model()->count();
		$weekIds 	=	array();
		$allWeeks 	=	Helpers::getSeasonWeekCount($teamCount);

		for($i=1; $i<=$allWeeks; $i++)
		{
			$week 	=	new Week;
			$week->season_id 	=	$seasonId;
			$week->title 		=	'Week - ' . $i;
			$week->save();

			$weekIds[]	=	$week->week_id;
		}

		return $weekIds;
	}

	public function isExistsCompletedWeekBySeasonId($seasonId)
	{
		$conditions 	=	'season_id=:season_id AND status=:status';
		$params 		=	array(':season_id' => $seasonId, ':status' => self::STATUS_COMPLETED);

		$isExists  		=	Week::model()->exists($conditions, $params);

		return $isExists;
	}

	public function completeSeasonWeeks($seasonId)
	{
		$attributes = 	array('status' => self::STATUS_COMPLETED);

		$condition 	= 	'season_id=:season_id AND status=:status';

		$params 	= 	array(':season_id' => $seasonId, ':status' => self::STATUS_NOT_COMPLETED);

		$status 	= 	Week::model()->updateAll($attributes, $condition, $params);

		return $status;
	}

	public function getLastWeekIdBySeasonId($seasonId)
	{
		$condition 	= 	'season_id=:season_id AND status=:status';
		$params 	= 	array(':season_id' => $seasonId, ':status' => self::STATUS_COMPLETED);
		$data 		= 	Week::model()->lastOne()->find($condition, $params);

		return $data->week_id;
	}
}
