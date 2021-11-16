<?php

namespace Tq\Qbs\V1;

class QuestionQueryOptions
{
    private $page = 1;
    private $page_size = 5;
    private $fetch_options = 0;
    private $fetch_answers = 0;
    private $fetch_method = 0;
    private $fetch_analyse = 0;
    private $fetch_discuss = 0;
    private $fetch_category = 0;


    public function __construct($page, $page_size)
    {
        $this->page = intval($page);
        $this->page_size = intval($page_size);
    }

    /**
     * 设置页码
     * @param $page
     * @return $this
     */
    public function page($page)
    {
        $this->page = intval($page);
        return $this;
    }

    /**
     * 设置每页最大展示数
     * @param $page_size
     * @return $this
     */
    public function pageSize($page_size)
    {
        $this->page_size = intval($page_size);
        return $this;
    }

    /**
     * 是否获取选项
     * @param $fetch_options
     * @return $this
     */
    public function fetchOptions($fetch_options)
    {
        $this->fetch_options = $fetch_options ? 1 : 0;
        return $this;
    }

    /**
     * 是否获取答案
     * @param $fetch_answers
     * @return $this
     */
    public function fetchAnswers($fetch_answers)
    {
        $this->fetch_answers = $fetch_answers ? 1 : 0;
        return $this;
    }

    /**
     * 是否获取解答
     * @param $fetch_method
     * @return $this
     */
    public function fetchMethod($fetch_method)
    {
        $this->fetch_method = $fetch_method ? 1 : 0;
        return $this;
    }

    /**
     * 是否获取解析
     * @param $fetch_analyse
     * @return $this
     */
    public function fetchAnalyse($fetch_analyse)
    {
        $this->fetch_analyse = $fetch_analyse ? 1 : 0;
        return $this;
    }

    /**
     * 是否获取点评
     * @param $fetch_discuss
     * @return $this
     */
    public function fetchDiscuss($fetch_discuss)
    {
        $this->fetch_discuss = $fetch_discuss ? 1 : 0;
        return $this;
    }

    /**
     * 是否获取题型
     * @param $fetch_category
     * @return $this
     */
    public function fetchCategory($fetch_category)
    {
        $this->fetch_category = $fetch_category ? 1 : 0;
        return $this;
    }

    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * @return int
     */
    public function getPageSize(): int
    {
        return $this->page_size;
    }

    /**
     * @return int
     */
    public function getFetchOptions(): int
    {
        return $this->fetch_options;
    }

    /**
     * @return int
     */
    public function getFetchAnswers(): int
    {
        return $this->fetch_answers;
    }

    /**
     * @return int
     */
    public function getFetchMethod(): int
    {
        return $this->fetch_method;
    }

    /**
     * @return int
     */
    public function getFetchAnalyse(): int
    {
        return $this->fetch_analyse;
    }

    /**
     * @return int
     */
    public function getFetchDiscuss(): int
    {
        return $this->fetch_discuss;
    }

    /**
     * @return int
     */
    public function getFetchCategory(): int
    {
        return $this->fetch_category;
    }
}
