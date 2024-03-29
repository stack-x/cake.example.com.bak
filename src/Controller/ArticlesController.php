<?php

namespace App\Controller;

class ArticlesController extends AppController
{
    public function index()
    {

        $this->loadComponent('Paginator');
        $articles = $this->Paginator->paginate(
            $this->Articles->find()
        );

        $this->set(compact('articles'));
    }

    public function view($slug = null) {
        $article = $this->Articles->findBySlug($slug)->contain(['Users'])->firstOrFail();
        $this->set(compact('article'));
    }

    public function add()
    {

        if(empty($this->request->session()->check('Auth.User.id'))) {
            $this->Flash->error(__('Your need to be logged in to do that.'));
            return $this->redirect('/');
        }

        $article = $this->Articles->newEntity();
        if ($this->request->is('post')) {
            $article = $this->Articles->patchEntity($article, $this->request->getData());
            // Hardcoding the user_id is temporary, and will be removed later
            // when we build authentication out.

            $article->user_id = $this->request->session()->read('Auth.User.id');

            if ($this->Articles->save($article)) {
                $this->Flash->success(__('Your article has been saved.'));
                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('Unable to add your article.'));
        }
        $this->set('article', $article);
    }

    public function edit($slug)
    {
        if(empty($this->request->session()->check('Auth.User.id'))) {
            $this->Flash->error(__('Your need to be logged in to do that.'));
            return $this->redirect('/');
        }
        $article = $this->Articles->findBySlug($slug)->firstOrFail();
        if ($this->request->is(['post', 'put'])) {
            $this->Articles->patchEntity($article, $this->request->getData());
            if ($this->Articles->save($article)) {
                $this->Flash->success(__('Your article has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to update your article.'));
        }

        $this->set('article', $article);
    }

    public function delete($slug)
    {
        if(empty($this->request->session()->check('Auth.User.id'))) {
            $this->Flash->error(__('Your need to be logged in to do that.'));
            return $this->redirect('/');
        }
        $this->request->allowMethod(['post', 'delete']);

        $article = $this->Articles->findBySlug($slug)->firstOrFail();
        if ($this->Articles->delete($article)) {
            $this->Flash->success(__('The {0} article has been deleted.', $article->title));
            return $this->redirect(['action' => 'index']);
        }
    }
}
