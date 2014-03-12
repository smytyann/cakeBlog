<?php
class Post extends AppModel {
    public $validate = array(
        'title' => array(
            'rule' => 'notEmpty'
        ),
        'body' => array(
            'rule' => 'notEmpty'
        )
    );
	public function isOwnedBy($post, $user) {//We are checking to see whether the user is authorized to edit the post or not
    return $this->field('id', array('id' => $post, 'user_id' => $user)) === $post;//we are checking if the User_Id match with the post id
}
}
?>