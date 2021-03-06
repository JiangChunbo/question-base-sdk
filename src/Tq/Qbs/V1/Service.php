<?php

namespace Tq\Qbs\V1;

use Exception;

require_once 'Payload.php';
require_once 'HttpClient.php';

class Service
{
    /**
     * @var HttpClient
     */
    private $http_client;

    /**
     * @var string
     */
    private $open_id;

    /**
     * @var string
     */
    private $open_secret;

    /**
     * @var string
     */
    private $open_key;


    /**
     * @var string
     */
    private $token;

    public function __construct($open_id, $open_secret, $open_key)
    {
        $this->http_client = new HttpClient();
        $this->open_id = $open_id;
        $this->open_secret = $open_secret;
        $this->open_key = $open_key;
    }


    /**
     * 检查是否设置 token
     * @throws Exception
     */
    public function checkToken()
    {
        if (!$this->token) {
            throw new Exception("还未设置 Token");
        }
    }

    /**
     * 用户注册，重复调用会修改 username，password
     * @param $user_uuid string 同一个应用下的唯一标识
     * @param $username  string 用户名，可以不唯一
     * @param $password  string 密码
     * @return mixed
     * @throws Exception
     */
    public function register($user_uuid, $username, $password)
    {
        if (strlen($user_uuid) <= 0) {
            throw new Exception("User UUID 不能为空");
        }
        if (strlen($username) <= 0) {
            throw new Exception("Username 不能为空");
        }
        if (strlen($password) <= 0) {
            throw new Exception("Password 不能为空");
        }

        $payload = Payload::encrypt([
            'open_secret' => $this->open_secret,
            'user_uuid' => $user_uuid,
            'username' => $username,
            'password' => $password
        ], $this->open_key);
        $response = $this->http_client->post('user/register/', [
            'open_id' => $this->open_id,
            'encrypted' => $payload
        ]);
        $code = $response->getStatusCode();
        $body = $response->getBody()->getContents();
        if ($code == 200 && ($body = json_decode($body, true))['state'] == 0) {
            return $body;
        }
        throw new Exception($body);
    }


    /**
     * 获取用户信息，返回结果与 register 基本一致
     * @return mixed
     * @throws Exception
     */
    public function userInfo()
    {
        $this->checkToken();
        $headers = [
            'X-Token' => $this->token
        ];
        $response = $this->http_client->get('user/info/', [], $headers);
        $code = $response->getStatusCode();
        $body = $response->getBody()->getContents();
        if ($code == 200 && ($body = json_decode($body, true))['state'] == 0) {
            return $body;
        }
        throw new Exception($body);
    }


    /**
     * 登录，获得 token
     * @param $user_uuid string 同一个应用下的唯一标识
     * @param $password  string 密码
     * @return mixed
     * @throws Exception
     */
    public function getToken($user_uuid, $password)
    {
        if (strlen($user_uuid) <= 0) {
            throw new Exception("User UUID 不能为空");
        }
        if (strlen($password) <= 0) {
            throw new Exception("Password 不能为空");
        }
        $payload = Payload::encrypt([
            'user_uuid' => $user_uuid,
            'password' => $password
        ], $this->open_key);
        $response = $this->http_client->post('user/login/', [
            'open_id' => $this->open_id,
            'encrypted' => $payload
        ]);
        $code = $response->getStatusCode();
        $body = $response->getBody()->getContents();
        if ($code == 200 && ($res = json_decode($body, true))['state'] == 0) {
            return $res['access_token'];
        }
        throw new Exception($body);
    }

    /**
     * 设置 Token，用于其他接口的调用
     * @param $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }


    /**
     * 获取学段列表
     * @return mixed
     * @throws Exception
     */
    public function fetchAllStages()
    {
        $this->checkToken();
        $headers = [
            'X-Token' => $this->token
        ];
        $response = $this->http_client->get('stage/list/', [], $headers);
        $code = $response->getStatusCode();
        $body = $response->getBody()->getContents();
        if ($code == 200 && ($res = json_decode($body, true))['state'] == 0) {
            return $res['stages'];
        }
        throw new Exception($body);
    }


    /**
     * 获取系统所有年级列表
     * @param int $stage_id
     * @return mixed
     * @throws Exception
     */
    public function fetchAllGrades($stage_id = 0)
    {
        $this->checkToken();
        $query = [
            'stage_id' => $stage_id
        ];
        $headers = [
            'X-Token' => $this->token
        ];
        $response = $this->http_client->get('grade/list/', $query, $headers);
        $code = $response->getStatusCode();
        $body = $response->getBody()->getContents();
        if ($code == 200 && ($res = json_decode($body, true))['state'] == 0) {
            return $res['grades'];
        }
        throw new Exception($body);
    }

    /**
     * 获得系统所有教材版本
     * @return mixed
     * @throws Exception
     */
    public function fetchAllEditions()
    {
        $this->checkToken();
        $headers = [
            'X-Token' => $this->token
        ];
        $response = $this->http_client->get('edition/list/', [], $headers);
        $code = $response->getStatusCode();
        $body = $response->getBody()->getContents();
        if ($code == 200 && ($res = json_decode($body, true))['state'] == 0) {
            return $res['editions'];
        }
        throw new Exception($body);
    }


    /**
     * 获取所有 subject
     * @param $stage_id
     * @return mixed
     * @throws Exception
     */
    public function fetchAllSubjects($stage_id = 0)
    {
        $this->checkToken();
        $headers = [
            'X-Token' => $this->token
        ];
        $query = [
            'stage_id' => $stage_id
        ];
        $response = $this->http_client->get('subject/list/', $query, $headers);
        $code = $response->getStatusCode();
        $body = $response->getBody()->getContents();
        if ($code == 200 && ($res = json_decode($body, true))['state'] == 0) {
            return $res['subjects'];
        }
        throw new Exception($body);
    }


    /**
     * 根据条件获取 Book 列表
     * @param $subject_id
     * @param $grade_id
     * @return mixed
     * @throws Exception
     */
    public function fetchBooks($subject_id, $grade_id)
    {
        $this->checkToken();
        if (($subject_id = intval($subject_id)) <= 0) {
            throw new Exception("Subject ID 必须大于 0");
        }
        if (($grade_id = intval($grade_id)) <= 0) {
            throw new Exception("Grade ID 必须大于 0");
        }
        $headers = [
            'X-Token' => $this->token
        ];
        $query = [
            'subject_id' => $subject_id,
            'grade_id' => $grade_id
        ];
        $response = $this->http_client->get('book/list1/', $query, $headers);
        $code = $response->getStatusCode();
        $body = $response->getBody()->getContents();
        if ($code == 200 && ($res = json_decode($body, true))['state'] == 0) {
            return $res['books'];
        }
        throw new Exception($body);
    }

    /**
     * 以唯一标识 Book ID，获得目录树
     * @param $book_id
     * @return mixed
     * @throws Exception
     */
    public function fetchDirectories1($book_id)
    {
        $this->checkToken();
        if (($book_id = intval($book_id)) <= 0) {
            throw new Exception("Book ID 必须大于 0");
        }
        $query = [
            'book_id' => $book_id
        ];
        $headers = [
            'X-Token' => $this->token
        ];
        $response = $this->http_client->get('book/directory/tree1/', $query, $headers);
        $code = $response->getStatusCode();
        $body = $response->getBody()->getContents();
        if ($code == 200 && ($res = json_decode($body, true))['state'] == 0) {
            return $res['directories'];
        }
        throw new Exception($body);
    }

    /**
     * 以学科，年级，册作为联合唯一标识，获取目录树
     * @param $subject_id int 学科
     * @param $grade_id   int 年级
     * @param $term       int 1 上册 2 下册 0 全一册 相互独立
     * @return mixed
     * @throws Exception
     */
    public function fetchDirectories2($subject_id, $grade_id, $term)
    {
        $this->checkToken();
        if (($subject_id = intval($subject_id)) <= 0) {
            throw new Exception("Subject ID 必须大于 0");
        }
        if (($grade_id = intval($grade_id)) <= 0) {
            throw new Exception("Grade ID 必须大于 0");
        }
        if (!in_array(($term = intval($term)), [0, 1, 2])) {
            throw new Exception("Term 可选值 0, 1, 2");
        }
        $query = [
            'open_id' => $this->open_id,
            'subject_id' => $subject_id,
            'grade_id' => $grade_id,
            'term' => $term
        ];
        $headers = [
            'X-Token' => $this->token
        ];
        $response = $this->http_client->get('book/directory/tree2/', $query, $headers);
        $code = $response->getStatusCode();
        $body = $response->getBody()->getContents();
        if ($code == 200 && ($res = json_decode($body, true))['state'] == 0) {
            return $res['directories'];
        }
        throw new Exception($body);
    }


    /**
     * 根据 Directory 和 Category
     * @param int                  $directory_id
     * @param int                  $category_id 题型，选填
     * @param QuestionQueryOptions $questionQueryOptions
     * @return mixed
     * @throws Exception
     */
    public function fetchQuestions1($directory_id, $category_id, $questionQueryOptions)
    {
        $this->checkToken();
        if (($directory_id = intval($directory_id)) <= 0) {
            throw new Exception("Subject ID 必须大于 0");
        }
        $query = [
            'directory_id' => $directory_id,
            'category_id' => $category_id,
            'page' => $questionQueryOptions->getPage(),
            'limit' => $questionQueryOptions->getPageSize()
        ];
        $query['fetch_options'] = $questionQueryOptions->getFetchOptions();
        $query['fetch_answers'] = $questionQueryOptions->getFetchAnswers();
        $query['fetch_method'] = $questionQueryOptions->getFetchMethod();
        $query['fetch_analyse'] = $questionQueryOptions->getFetchAnalyse();
        $query['fetch_discuss'] = $questionQueryOptions->getFetchDiscuss();
        $query['fetch_category'] = $questionQueryOptions->getFetchCategory();
        $headers = [
            'X-Token' => $this->token
        ];
        $response = $this->http_client->get('question/list1/', $query, $headers);
        $code = $response->getStatusCode();
        $body = $response->getBody()->getContents();
        if ($code == 200 && ($res = json_decode($body, true))['state'] == 0) {
            return $res['questions'];
        }
        throw new Exception($body);
    }
}
