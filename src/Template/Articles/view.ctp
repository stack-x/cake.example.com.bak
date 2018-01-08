<h1><?php echo h($article->title); ?></h1>

<p>
    <small>
    By: <?php echo $article->user->first_name .
                    '&nbsp;'.
                   $article->user->last_name;
       ?>
   </small>
</p>

<p><?php echo h($article->body); ?></p>
<p><small><?php echo $article->created->format(DATE_RFC850) ?></small></p>

<?php if(!empty($this->request->session()->check('Auth.User.id'))): ?>
    <p><?php echo $this->Html->link('Edit', ['action' => 'edit', $article->slug]) ?></p>
<?php endif; ?>
