<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Герман
 * Date: 28.06.13
 * Time: 23:05
 * To change this template use File | Settings | File Templates.
 */

class InterviewController extends Controller{
    public function indexAction(){
        $this->view->generate(array(
            'active_interview' => Interview::first(['type' => 'active'])
        ));
    }

    public function editAction($params){
        $id = NULL;
        if(isset($params['id'])){
            /** @var $interview Interview */
            $interview = Interview::find($params['id']);
            if(isset($interview))
                $id = $interview->getId();
        }
        $this->view->generate(array(
            'id' => $id
        ));
    }

    public function saveAction($params){
        /** @var $interview Interview */
        $params['interview'] = json_decode($params['interview'], TRUE);
        $interview           = Interview::find($params['interview']['id']);
        if(empty($interview))
            $interview = Interview::create($params['interview']);
        else
            $interview->save($params['interview']);
        $interview->setQuestions($params['interview']['questions']);
        $this->view->status(202);
    }

    public function jsonAction($params){
        $id        = $params['id'];
        $interview = NULL;
        if(!empty($id))
            $interview = Interview::find($id);
        $this->view->generate(['interview' => $interview], ['template_view' => FALSE]);
    }

    public function listAction(){
        $this->view->generate(['interviews' => Interview::all()]);
    }

    public function activateAction($params){
        /** @var $interview Interview */
        if($interview = Interview::find($params['id']))
            $interview->activate();
        header('Location: /interview/list/');
    }

    public function closeAction($params){
        /** @var $interview Interview */
        if($interview = Interview::find($params['id']))
            $interview->close();
        header('Location: /interview/list/');
    }

    public function deleteAction($params){
        Interview::delete($params['id']);
        header('Location: /interview/list/');
    }

    public function finishAction($params){
        /** @var $interview Interview */
        $interview = Interview::find($params['id']);
        if($interview && $interview->saveResults($params['questions']))
            header('Location: /interview/result/?id='.$params['id']);
        else
            header('Location: /');
    }

    public function resultAction($params){
        /** @var $interview Interview */
        if($interview = Interview::find($params['id']))
            $this->view->generate([
                'results'   => $interview->getResults($params['conditions']),
                'interview' => $interview
            ]);
        else
            header('location: /forbidden');
    }

    public function adminresultAction($params){
        $this->resultAction($params);
    }
}