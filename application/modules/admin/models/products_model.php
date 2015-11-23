<?php

class Products_model extends CI_Model
{
    protected $_table = "tbl_products";
    protected $_cate = "tbl_procate";
    protected $_image = "tbl_images";
    protected $_table_brand = "tbl_brands";

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_products()
    {
        $this->db->select('*');
        $this->db->from($this->_table);
        $this->db->join($this->_table_brand, $this->_table . '.brand_id =' . $this->_table_brand . '.brand_id');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_product_by_id($id)
    {
        $this->db->select('*');
        $this->db->from($this->_table);
        $this->db->where("pro_id", $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_total_record()
    {
        $query = $this->db->get($this->_table);
        return $query->num_rows();
    }

    public function get_products_limit($start, $limit)
    {
        $this->db->select("*");
        $this->db->limit($limit, $start);
        $this->db->order_by("pro_id", "DESC");
        $this->db->from($this->_table);
        $this->db->join($this->_table_brand, $this->_table . '.brand_id =' . $this->_table_brand . '.brand_id');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function search_product_rows($keywords, $search_type)
    {
        if ($search_type == 1) {
            $this->db->like("pro_name", "$keywords");
            $query = $this->db->get($this->_table);
            return $query->num_rows();
        } else if ($search_type == 2) {
            $this->db->where("pro_id", "$keywords");
            $query = $this->db->get($this->_table);
            return $query->num_rows();
        } else if ($search_type == 3) {
            $this->db->select("brand_id");
            $this->db->like("brand_name", "$keywords");
            $query = $this->db->get($this->_table_brand);
            $brand_id = array();
            foreach ($query->result_array() as $key => $value) {
                $brand_id[] = $value['brand_id'];
            }
            $this->db->where_in("brand_id", $brand_id);
            $query = $this->db->get($this->_table);
            return $query->num_rows();
        }
    }

    public function search_products_limit($keywords, $search_type, $start, $limit, $field, $order)
    {
        if ($search_type == 1) {
            $this->db->select("*");
            $this->db->like("pro_name", "$keywords");
            $this->db->limit($limit, $start);
            $this->db->join($this->_table_brand, $this->_table . '.brand_id =' . $this->_table_brand . '.brand_id');
            $query = $this->db->get($this->_table);
            return $query->result_array();
        } else if ($search_type == 2) {
            $this->db->select("*");
            $this->db->join($this->_table_brand, $this->_table . '.brand_id =' . $this->_table_brand . '.brand_id');
            $this->db->where("pro_id", "$keywords");
            $query = $this->db->get($this->_table);
            return $query->result_array();
        } else if ($search_type == 3) {
            $this->db->select("*");
            $this->db->like("brand_name", "$keywords");
            $this->db->limit($limit, $start);
            $this->db->order_by($field, $order);
            $this->db->from($this->_table);
            $this->db->join($this->_table_brand, $this->_table . '.brand_id =' . $this->_table_brand . '.brand_id');
            $query = $this->db->get();
            return $query->result_array();
        }
    }

    public function delete_product($id)
    {
        $this->db->where("pro_id", $id);
        $this->db->delete($this->_cate);

        $this->db->where("pro_id", $id);
        $this->db->delete($this->_image);

        $this->db->where("pro_id", $id);
        $this->db->delete($this->_table);
    }

    //Get cate id from tbl_procate
    public function getCateId($id)
    {
        $this->db->select("cate_id");
        $this->db->where("pro_id", $id);
        $query = $this->db->get($this->_cate);
        return $query->result_array();
    }

    public function getInforUpdate($id)
    {
        $this->db->select("*");
        $this->db->where("pro_id", $id);
        $query = $this->db->get($this->_table);
        return $query->row_array();
    }

    //Update product
    public function update($data, $id)
    {
        $this->db->where("pro_id = $id");
        $this->db->update($this->_table, $data);
    }

    //Lay ra anh nho
    public function getImagesThumb($id)
    {
        $this->db->select("*");
        $this->db->where("pro_id", $id);
        $query = $this->db->get($this->_image);

        return $query->result_array();
    }

    //Lay ra anh lon
    public function getImages($id)
    {
        $data = array(
            'pro_id' => $id,
            'img_status' => '1'
        );
        $this->db->where($data);
        $query = $this->db->get($this->_image);

        return $query->row_array();
    }

    //Update ThumbImage
    public function updateThumb($value, $id)
    {
        $sql = "INSERT INTO tbl_images (img_id,pro_id,img_link,img_status) VALUES ('','" . $id . "', '" . $value . "','1')";
        $this->db->query($sql);
    }

    //Delete Thumb
    public function deleteThumb($id)
    {
        $this->db->where("pro_id", $id);
        $this->db->delete($this->_image);
    }

    //Delete image from tbl_image
    public function deleteImage($pro_id, $img_link)
    {
        $this->db->where("pro_id", $pro_id);
        $this->db->where("img_link", $img_link);
        $this->db->delete($this->_image);

    }

    //Delete product from tbl_procate
    public function deleteCate($id)
    {
        $this->db->where("pro_id", $id);
        $this->db->delete($this->_cate);
    }

    //Insert Category
    public function insertCate($value, $id)
    {
        $data = array(
            'pro_id' => $id,
            'cate_id' => $value
        );
        $this->db->insert($this->_cate, $data);
    }

    public function get_all_brand()
    {
        $data = $this->db->get("tbl_brands")->result_array();
        if ($data == '') return false;
        else return $data;
    }

    public function get_all_category()
    {
        $this->db->order_by("cate_orderby");
        $data = $this->db->get("tbl_categories")->result_array();
        if ($data == '') return false;
        $list = array();
        foreach ($data as $key => $value) {
            $list[$value['cate_id']] = $value;
        }
        foreach ($list as $key => $value) {
            if ($value['parent_id'] == 0) {
                $list[$key]['level'] = 0;
            } else {
                $list[$key]['level'] = $list[$value['parent_id']]['level'] + 1;
            }
        }
        return $list;
    }

    public function insert($data)
    {
        if ($data == '') return false;
        $this->db->insert($this->_table, $data);
        return $this->db->insert_id();
    }

    public function insert_image($data)
    {
        if ($data == '') return false;
        $this->db->insert("tbl_images", $data);
        return $this->db->insert_id();
    }

    public function insert_procate($data)
    {
        if ($data == '') return false;
        $this->db->insert("tbl_procate", $data);
        return $this->db->insert_id();
    }

}

?>