<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Герман
 * Date: 29.06.13
 * Time: 2:36
 * To change this template use File | Settings | File Templates.
 */

class Question extends Model{
    protected static $_table = 'questions';
    protected static $_attrs = array('interview_id', 'text', 'type', 'required');
    protected static $_public_attrs = array('text', 'type', 'required');

    /**
     * @var int
     */
    protected $id;
    /**
     * @var int
     */
    protected $interview_id;
    /**
     * @var string
     */
    protected $text;
    /**
     * @var string
     */
    protected $type;
    /**
     * @var bool
     */
    protected $required;

    /**
     * @return int
     */
    public function getId(){
        return $this->id;
    }

    /**
     * @return int
     */
    public function getInterviewId(){
        return $this->interview_id;
    }

    /**
     * @param string $text
     */
    public function setText($text){
        $this->text = $text;
    }

    /**
     * @return string
     */
    public function getText(){
        return $this->text;
    }

    /**
     * @param string $type
     */
    public function setType($type){
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getType(){
        return $this->type;
    }

    /**
     * @param bool $required
     */
    public function setRequired($required){
        $this->required = $required;
    }

    /**
     * @return bool
     */
    public function getRequired(){
        return $this->required;
    }

    /**
     * @return Answer[]|null
     */
    public function getAnswers(){
        return Answer::all(array('question_id' => $this->id));
    }

    public function addAnswer($params){
        $params['question_id'] = $this->id;
        return Answer::create($params);
    }

    public function setAnswers($answers){
        if(!is_array($answers))
            return FALSE;
        $allAnswers = $this->getAnswers();
        $ids        = [];
        foreach($answers as $a){
            $aid = intval($a['id']);
            /** @var $answer Answer */
            if($aid && $answer = Answer::find($aid)){
                $answer->save($a);
                $ids[] = $aid;
            } else
                $this->addAnswer($a);
        }
        foreach($allAnswers as $a1)
            if(!in_array($a1->getId(), $ids))
                $a1->remove();
        return TRUE;
    }

    public function asJson(){
        $question            = get_object_vars($this);
        $question['answers'] = array_map(function ($answer){
            /** @var $answer Answer */
            return $answer->asJson();
        }, $this->getAnswers());
        return $question;
    }

    public function isRequired(){
        return $this->required == '1';
    }
}