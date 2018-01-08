<h1>Articles</h1>
<?php if(!empty($this->request->session()->check('Auth.User.id'))): ?>
    <p><?php echo $this->Html->link("Add Article", ['action' => 'add']) ?></p>
<?php endif; ?>
<table>
    <thead>
        <tr>
            <th>Title</th>
            <th>Created</th>
            <?php if(!empty($this->request->session()->check('Auth.User.id'))): ?>
                <th>Actions</th>
            <?php endif; ?>
        </tr>
    </thead>

    <tbody>

        <?php foreach($articles as $article): ?>
            <tr>
                <td>
                    <?php
                    echo $this->Html->link(
                        $article->title,
                        [
                            'action'=>'view',
                            $article->slug
                        ]
                    );
                    ?>
                </td>
                <td>
                    <?php echo $article->created->format(DATE_RFC850); ?>
                </td>
                <?php if(!empty($this->request->session()->check('Auth.User.id'))): ?>
                    <td>
                        <?php echo $this->Html->link('Edit', ['action'=>'edit', $article->slug]); ?>
                        <?php echo $this->Form->postLink(
                            'Delete',
                            ['action' => 'delete', $article->slug],
                            ['confirm' => 'Are you sure?'])
                        ?>
                    </td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>

    </tbody>

</table>
