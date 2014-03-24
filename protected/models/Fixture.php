<?php

/**
 * This is the model class for table "fixture".
 *
 * The followings are the available columns in table 'fixture':
 * @property integer $fixture_id
 * @property integer $week_id
 * @property integer $home_team_id
 * @property integer $away_team_id
 * @property integer $home_team_goal
 * @property integer $away_team_goal
 * @property string $status
 *
 * The followings are the available model relations:
 * @property Team $awayTeam
 * @property Team $homeTeam
 * @property Week $week
 */
class Fixture extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'fixture';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('week_id, home_team_id, away_team_id', 'required'),
			array('week_id, home_team_id, away_team_id, home_team_goal, away_team_goal', 'numerical', 'integerOnly'=>true),
			array('status', 'length', 'max'=>13),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('fixture_id, week_id, home_team_id, away_team_id, home_team_goal, away_team_goal, status', 'safe', 'on'=>'search'),
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
			'awayTeam' => array(self::BELONGS_TO, 'Team', 'away_team_id'),
			'homeTeam' => array(self::BELONGS_TO, 'Team', 'home_team_id'),
			'week' => array(self::BELONGS_TO, 'Week', 'week_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'fixture_id' => 'Fixture',
			'week_id' => 'Week',
			'home_team_id' => 'Home Team',
			'away_team_id' => 'Away Team',
			'home_team_goal' => 'Home Team Goal',
			'away_team_goal' => 'Away Team Goal',
			'status' => 'Status',
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

		$criteria->compare('fixture_id',$this->fixture_id);
		$criteria->compare('week_id',$this->week_id);
		$criteria->compare('home_team_id',$this->home_team_id);
		$criteria->compare('away_team_id',$this->away_team_id);
		$criteria->compare('home_team_goal',$this->home_team_goal);
		$criteria->compare('away_team_goal',$this->away_team_goal);
		$criteria->compare('status',$this->status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Fixture the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function createSeasonAllFixtureWithWeekIds($weekIds)
	{
Helpers::printPre($weekIds);
		$teamIds 	=	Team::model()->getIds();
		$seasonFixture 	=	Helpers::scheduler($teamIds);
Helpers::printPre($seasonFixture);

		$weekIndex = 0;

		// first half
		foreach($seasonFixture as $rowWeek)
		{
			foreach($rowWeek as $matchesIndex => $matchesRow)
			{
				$fixture 					=	new Fixture;
				$fixture->week_id 			=	$weekIds[$weekIndex];
				$fixture->home_team_id		=	$rowWeek[$matchesIndex]['home'];
				$fixture->away_team_id		=	$rowWeek[$matchesIndex]['away'];
				$fixture->home_team_power	=	Helpers::getTeamPower();
				$fixture->away_team_power	=	Helpers::getTeamPower();
				$fixture->save();
			}

			$weekIndex++;
		}

		// second half
		foreach($seasonFixture as $rowWeek)
		{
			foreach($rowWeek as $matchesIndex => $matchesRow)
			{
				$fixture 					=	new Fixture;
				$fixture->week_id 			=	$weekIds[$weekIndex];
				$fixture->home_team_id		=	$rowWeek[$matchesIndex]['away'];
				$fixture->away_team_id		=	$rowWeek[$matchesIndex]['home'];
				$fixture->home_team_power	=	Helpers::getTeamPower();
				$fixture->away_team_power	=	Helpers::getTeamPower();
				$fixture->save();
			}

			$weekIndex++;
		}
	}
}
