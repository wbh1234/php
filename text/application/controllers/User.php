<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model('Article_model');
    }

    public function vue_login(){
        header('Access-Control-Allow-Origin:* ');
        header('Access-Control-Allow-Headers: X-Requested-With, Content-Type');
        $name = $this->input->get('username');
        $pwd = $this->input->get('pwd');
        $user = $this->User_model->get_user_by_email_and_pwd($name,$pwd);

        $this->session->set_userdata(array(
            "user" =>$user
        ));
        echo json_encode($user);
    }


    public function index()
    {

        $this->load->library('pagination');
        $total = $this->Article_model->get_count_article();

        $config['base_url'] = base_url().'User/index';
        $config['total_rows'] = $total;
        $config['per_page'] = 2;

        $this->pagination->initialize($config);
        $links = $this->pagination->create_links();

        $results = $this->Article_model->get_article_list($this->uri->segment(3),$config['per_page']);


        $user = $this->session->userdata('user');

        $types = $this->Article_model->get_article_type();

        $this->load->view('index',array('list'=>$results,'types'=>$types,'links'=>$links));

    }
    public function index_logined(){
        $this->load->library('pagination');

        $user = $this->session->userdata('user');

        $total = $this->Article_model->get_logined_count_article($user->user_id);


        $config['base_url'] = base_url().'User/index_logined';//当前控制器方法
        $config['total_rows'] = $total;//总数
        $config['per_page'] = 3;//每页显示条数

        $this->pagination->initialize($config);
        $links = $this->pagination->create_links();

        $results = $this->Article_model->get_logined_article_list($this->uri->segment(3),$config['per_page'],$user->user_id);

        $types = $this->Article_model->get_logined_article_type($user->user_id);

        $this->load->view('index_logined',array('list'=>$results,'types'=>$types,'links'=>$links));
//        $this->load->view('index_logined');
//        $links = $this->pagination->create_links();
//        $types = $this->Article_model->get_article_type()
//        $results = $this->Article_model->get_article_list($this->uri->segment(3),$config['per_page']);
//        $this->load->view('index_logined',array('list'=>$results,'types'=>$types,'links'=>$links));

    }
    public function login()
    {
        $this->load->view('login');
    }

    public function captcha()
    {

        $this->load->helper('captcha');
        $rand = rand(1000,9999);

        $this->session->set_userdata(array(
            "captcha"=>$rand
        ));

        $vals = array(
            'word'      => $rand,
            'img_path'  => './captcha/',
            'img_url'   => base_url().'captcha/',
            'font_path' => './path/to/fonts/texb.ttf',
            'img_width' => '150',
            'img_height'    => 30,
            'expiration'    => 7200,
            'word_length'   => 8,
            'font_size' => 16,

            // White background and border, black text and red grid
            'colors'    => array(
                'background' => array(255, 255, 255),
                'border' => array(255, 255, 255),
                'text' => array(0, 0, 0),
                'grid' => array(255, 40, 40)
            )
        );

        $cap = create_captcha($vals);
        $img = $cap['image'];
        return $img;
    }
    public function change_code(){
        $img = $this->captcha();
        echo $img;
    }
    public function reg(){
        $img = $this->captcha();
        $this->load->view('reg',array('img'=>$img));

    }

    public function add_user() {
        $email = $this->input->get('email');
        $name = $this->input->get('name');
        $pwd = $this->input->get('pwd');
        $pwd2 = $this->input->get('pwd2');
        $gender = $this->input->get('gender');
        $province = $this->input->get('province');
        $city = $this->input->get('city');
        $code = $this->input->get('code');

        if($pwd != $pwd2){
            echo 'pwd-error';
            die();
        }
        $captcha = $this->session->userdata('captcha');
        if($code != $captcha){
            echo 'code-error';
            die();
        }

        $rows = $this->User_model->add(array(
            'username'=>$name,
            'email'=>$email,
            'password'=>$pwd,
            'sex'=>$gender,
            'province'=>$province,
            'city'=>$city
        ));

        if($rows > 0){
            echo 'success';
        }else{
            echo 'fail';
        }

    }

    public function check_email(){
        $email = $this->input->get('email');
        $result = $this->User_model->get_user_by_email($email);
        if(count($result) > 0){
            echo '1';
        }else{
            echo '0';
        }
    }

    public function check_login(){
        $email = $this->input->get('email');
        $pwd = $this->input->get('pwd');
        $result = $this->User_model->get_user_by_email($email);
        if(count($result) == 0){
            echo 'email not exist';
        }else{
            if($result[0]->password == $pwd){
                $this->session->set_userdata(array(
                    'user'=>$result[0]
                ));
                echo 'success';
            }else{
                echo 'password error';
            }
        }
    }

    public function auto_login(){
        $email = $this->input->get('email');
        $result = $this->User_model->get_user_by_email($email);
        $this->session->set_userdata(array(
            'user'=>$result[0]
        ));
        redirect("User/index_logined");
    }

    public function logout(){
        $this->session->unset_userdata('user');
        redirect("User/index");
    }

    public function adminIndex(){
        $this->load->view('adminIndex');
    }

    public function newBlog(){
        $user = $this->session->userdata('user');
        $types = $this->Article_model->get_type_by_user_id($user->user_id);

        $this->load->view('newBlog',array('types'=>$types));

    }

    public function add_publish(){


        $title = $this->input->get('title');
        $content = $this->input->get('content');
        $type_id = $this->input->get('type_id');
        $user = $this->session->userdata('user');

        if($title == null ){
            echo 'publish fail';
            die();
        }
        if($content == null ){
            echo 'publish also fail';
            die();
        }

        $rows = $this->Article_model->add_publish(array(
            'title'=>$title,
            'content'=>$content,
            'user_id'=>$user->user_id,
            'type_id'=>$type_id
        ));
        if($rows > 0){
//			redirect('user/login');
            echo 'success';
        }else{
            echo 'fail';
        }

    }

    public function editCatalog(){
        $user = $this->session->userdata('user');
        $types = $this->Article_model->get_logined_article_type($user->user_id);


        $this->load->view('editCatalog',array('types'=>$types));
    }

    public function blogCatalogs(){
        $user = $this->session->userdata('user');
        $types = $this->Article_model->get_logined_article_type($user->user_id);


        $this->load->view('blogCatalogs',array('types'=>$types));

    }
    public function add_type(){
        $name = $this->input->get('name');
        $user = $this->session->userdata('user');
        $rows = $this->Article_model->add_type($name,$user->user_id);
        if($rows > 0){
            echo 'success';
        }

    }
    public function edit_type(){
        $name = $this->input->get('name');
        $type_id = $this->input->get('typeId');

        $rows = $this->Article_model->edit_type($name,$type_id);
        if($rows > 0){
            echo 'success';
        }
    }

  public function del_type(){
        $type_id = $this->input->get('typeId');
        $user = $this->session->userdata('user');

        $result = $this->Article_model->get_type_by_id_userid($user->user_id,$type_id);
        if(count($result) == 0){
            echo 'fail';
        }else{
            $rows = $this->Article_model->del_type($type_id);
            if($rows > 0){
                echo 'success';
            }
        }
    }

    public function blogs(){
        $this->load->library('pagination');

        $user = $this->session->userdata('user');

        $total = $this->Article_model->get_logined_count_article($user->user_id);
        $config['base_url'] = base_url().'User/blogs';//当前控制器方法
        $config['total_rows'] = $total;//总数
        $config['per_page'] = 4;//每页显示条数

        $this->pagination->initialize($config);
        $links = $this->pagination->create_links();

        $results = $this->Article_model->get_logined_article_list($this->uri->segment(3),$config['per_page'],$user->user_id);
        $results1 = $this->Article_model->get_blogs_by_user($user->user_id);
        $types = $this->Article_model->get_logined_article_type($user->user_id);
        $this->load->view('blogs',array('total'=>$total,'list'=>$results,'types'=>$types,'links'=>$links,'result'=>$results1));
    }

    public function del_article(){
        $ids = $this->input->get('ids');
        $rows = $this->Article_model->del_article_by_id($ids);
        if($rows > 0){
            echo 'success';
        }
    }

    public function viewPost_comment(){
        $id = $this->input->get('id');
        $row = $this->Article_model->get_article_by_id($id);
        $date_str = $this->time_tran($row->post_date);
        $row->post_date = $date_str;
        $comments =  $this->Article_model->get_comment_by_article_id($id);

        //查询上一篇，下一篇

        //查询全部名称
        $result = $this->Article_model->get_article_list_all();
        $next_article = null;
        $prev_article = null;
        foreach($result as $index=>$article){
            if($article->article_id == $id){
                if($index > 0){
                    $prev_article = $result[$index-1];
                }
                if($index < count($result)-1){
                    $next_article = $result[$index+1];
                }
            }
        }


        $this->load->view('viewPost_comment',array(
           'article'=>$row,
            'comments'=>$comments,
            'next'=>$next_article,
            'prev'=>$prev_article
        ));
    }


    public function add_comment(){
        $content = $this->input->get('content');
        $article_id = $this->input->get('articleId');
        $user = $this->session->userdata('user');

        $rows = $this->Article_model->add_comment(array(
            'content'=>$content,
            'user_id'=>$user->user_id,
            'post_date'=>date("Y-m-d h:m:s"),
            'article_id'=>$article_id
        ));

        if($rows >0){
            echo 'success';
        }
    }

    public function blog_comments(){
        $this->load->view('blogComments');
    }

    function time_tran($the_time)
    {
        $now_time = date("Y-m-d H:i:s", time() + 8 * 60 *60);
        $now_time = strtotime($now_time);
        $show_time = strtotime($the_time);
        $dur = $now_time - $show_time;
        if($dur < 0){
            return $the_time;
        }else {
            if ($dur < 3600) {
                return floor($dur / 60).'分钟前';
            }else {
                if ($dur < 86400){
                    return floor($dur / 3600).'小时前';
                }else {
                    if($dur < 259200){
                        return floor($dur / 86400).'天前';
                    }else {
                        return $the_time;
                    }
                }
            }
        }
    }
}
