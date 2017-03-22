<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Герман
 * Date: 29.06.13
 * Time: 0:45
 * To change this template use File | Settings | File Templates.
 */

class Interview extends Model{

    protected static $_table = 'interviews';
    protected static $_attrs = array('name', 'type');
    protected static $_public_attrs = array('name', 'type');


    /**
     * @var integer
     */
    protected $id;
    /**
     * @var string
     */
    protected $name;
    /**
     * @var string
     */
    protected $type;

    /**
     * @return int
     */
    public function getId(){
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(){
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name){
        $this->name = $name;
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
     * @return Question[]|null
     */
    public function getQuestions(){
        return Question::all(['interview_id' => $this->id]);
    }

    /**
     * @param $params
     *
     * @return Question
     */
    public function addQuestion($params){
        $params['interview_id'] = $this->id;
        return Question::create($params);
    }

    public function setQuestions($questions){
        if(!is_array($questions))
            return FALSE;
        $allQuestions = $this->getQuestions();
        $ids          = [];
        foreach($questions as $q){
            $qid = intval($q['id']);
            if($qid && $question = Question::find($qid)){
                $question->save($q);
                $ids[] = $qid;
            } else
                $question = $this->addQuestion($q);
            $question->setAnswers($q['answers']);
        }
        foreach($allQuestions as $q1)
            if(!in_array($q1->getId(), $ids))
                $q1->remove();
        return TRUE;
    }

    public function asJson(){
        $interview              = get_object_vars($this);
        $interview['questions'] = array_map(function ($question){
            /** @var $question Question */
            return $question->asJson();
        }, $this->getQuestions());
        return $interview;
    }

    public function isActive(){
        return $this->type == 'active';
    }

    public function isClosed(){
        return $this->type == 'closed';
    }

    public function isDraft(){
        return $this->type == 'draft';
    }

    public function activate(){
        if(self::first(['type' => 'active']))
            return FALSE;
        return $this->save(['type' => 'active']);
    }

    public function close(){
        return $this->save(['type' => 'closed']);
    }

    public function saveResults($results){
        if($this->checkResults($results)){
            Result::create(['interview_id' => $this->id, 'data' => json_encode($results)]);
            return TRUE;
        }
        return FALSE;
    }

    public function checkResults($results){
        $questions = $this->getQuestions();
        foreach($questions as $question)
            if($question->isRequired()){
                $val = $results[$question->getId()];
                if(!isset($val) || is_array($val) && count($val) == 0)
                    return FALSE;
            }
        return TRUE;
    }

    public function getResults($conditions = [], $summ = TRUE){
        /** @var $results Result[] */
        $results = Result::all(['interview_id' => $this->id]);
        $datas   = [];
        foreach($results as $result)
            if($result->filter($conditions)){
                $datas[] = $result->getData();
            }

        $questions = $this->getQuestions();
        $res       = [];
        foreach($questions as $question){
            $qid               = $question->getId();
            $res[$qid]['text'] = $question->getText();
            $answers           = $question->getAnswers();
            foreach($answers as $answer)
                $res[$qid]['answers'][$answer->getId()] = [
                    'text'  => $answer->getText(),
                    'count' => 0
                ];
        }
        foreach($datas as $data)
            foreach($data as $q => $a)
                if(is_array($a))
                    foreach($a as $a1)
                        $res[$q]['answers'][$a1]['count']++;
                else
                    $res[$q]['answers'][$a]['count']++;
        return [
            'questions'  => $res,
            'results'    => count($datas),
            'conditions' => $conditions
        ];
    }
}