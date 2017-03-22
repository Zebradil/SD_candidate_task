<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Герман
 * Date: 29.06.13
 * Time: 2:36
 * To change this template use File | Settings | File Templates.
 */

class Answer extends Model{
    protected static $_table = 'answers';
    protected static $_attrs = array('question_id','text');
    protected static $_public_attrs = array('text');

    /**
     * @var int
     */
    protected $id;
    /**
     * @var int
     */
    protected $question_id;
    /**
     * @var string
     */
    protected $text;

    /**
     * @return int
     */
    public function getId(){
        return $this->id;
    }

    /**
     * @return int
     */
    public function getQuestionId(){
        return $this->question_id;
    }

    /**
     * @return string
     */
    public function getText(){
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText($text){
        $this->text = $text;
    }
}