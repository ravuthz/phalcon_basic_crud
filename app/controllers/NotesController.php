<?php

use Phalcon\Paginator\Adapter\Model as Paginator;

class NotesController extends ControllerBase {
    public function indexAction() {
        $numberPage = 5;

        if ($this->request->getQuery('page', 'int')) {
            $numberPage = $this->request->getQuery('page', 'int');
        }

        if ($name = $this->request->getQuery('name', 'string')) {
            $parameters['conditions'] = 'name LIKE :name:';
            $parameters['bind'] = ['name' => '%' . $name . '%'];
        }

        $parameters['order'] = 'id DESC';
        $users = Notes::find($parameters);

        $paginator = new Paginator([
            'data'  => $users,
            'limit' => 5,
            'page'  => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
    }

    public function newAction() {
        // render view "notes/new"
    }

    public function createAction() {
        $note = new Notes();
        $note->name = $this->request->getPost('name');
        $note->note = $this->request->getPost('note');
        $note->date = date("Y-m-d H:i:s");
        if (!$note->save()) {
            foreach ($note->getMessages() as $message) {
                $this->flash->error($message);
            }
        } else {
            $this->flash->success("Note was created successfully");
        }
        return $this->response->redirect("notes/new");
    }

    public function editAction($id) {
        // render view "notes/edit" with pass variable user
        $this->view->user = $this->findUser($id);
    }

    public function updateAction($id) {
        $user = $this->findUser($id);
        $note->name = $this->request->getPost('name');
        $note->note = $this->request->getPost('note');
        if (!$user->save()) {
            foreach ($user->getMessages() as $message) {
                $this->flash->error($message);
            }
        } else {
            $this->flash->success("Note was updated successfully");
        }
        return $this->response->redirect("notes/edit/$id");
    }

    public function destroyAction($id) {
        $user = $this->findUser($id);
        if (!$user->delete()) {
            foreach ($user->getMessages() as $message) {
                $this->flash->error($message);
            }
        } else {
            $this->flash->success("Note was deleted successfully");
        }
        return $this->response->redirect("notes");
    }

    private function findUser($id) {
        $user = Users::findFirstByid($id);
        if (!$user) {
            $this->flash->error("User id ($id) does not exist");
            return $this->response->redirect("notes");
        }
        return $user;
    }
}
