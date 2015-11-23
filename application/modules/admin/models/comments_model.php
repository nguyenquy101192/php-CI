<?php

class Comments_model extends CI_Model
{
    protected $_table = "tbl_feedback";

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_comments($start = -1, $limit = 0)
    {
        $this->db->select("*");
        if ($start != -1 && $limit != 0) {
            $this->db->limit($limit, $start);
        }
        $this->db->order_by('status asc, feed_time desc');
        $query = $this->db->get($this->_table);

        return $query->result_array();
    }

    public function approve($feed_id)
    {
        $sql = "UPDATE tbl_feedback SET status = NOT status WHERE feed_id='$feed_id'";
        $this->db->query($sql);
    }

    public function delete($comment_id)
    {
        $this->db->where("feed_id", $comment_id);
        $this->db->delete($this->_table);
    }
}

?>