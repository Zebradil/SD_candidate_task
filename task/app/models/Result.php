<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Герман
 * Date: 01.07.13
 * Time: 0:08
 * To change this template use File | Settings | File Templates.
 */

class Result extends Model{
    protected static $_table = 'results';
    protected static $_attrs = array('interview_id', 'data');

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
    protected $data;

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
     * @return string
     */
    public function getData(){
        return $this->data;
    }

    public function filter($conditions = NULL){
        if(is_array($conditions))
            foreach($conditions as $qid => $condition){
                $question = $this->data[$qid];
                if(empty($question))
                    return FALSE;
                elseif(is_array($question)){
                    if(count(array_intersect($question, $condition)) == 0)
                        return FALSE;
                } elseif(!in_array($question, $condition))
                    return FALSE;
            }
        return TRUE;
    }

    public function __construct(){
        $this->data = json_decode($this->data, TRUE);
    }
}