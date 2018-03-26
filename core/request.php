<?php

require_once(__DIR__ . '/db.php');
class App {

    protected $result;
    protected $orders;
    protected $years;
    protected $orders_created = [];
    protected $orders_paid = [];
    protected $orders_shipping = [];
    protected $orders_delivered = [];
    protected $orders_cancelled = [];
    protected $orders_indefined = [];

    public function __construct()
    {
        $this->db = new db();//создание объекта - экземпляра текущей базы данных
        if($_POST['highcharts'] == 'column' AND $_POST['date'] == 'day') {

            $arr = [];
            $this->db->query("SELECT * FROM orders_archive ORDER BY creation_time DESC")->all();
            $arr['category'] = ['01:00', '02:00', '03:00', '04:00', '05:00', '06:00',];
            $arr['data'] = [ 5, 10, 15, 20, 30, 50,];
            $arr['data2'] = [ 8, 6, 11, 45, 33, 14,];
            $this->setJSON($arr);

        } elseif ($_POST['highcharts'] == 'column' AND $_POST['date'] == 'year') {
            $arr = [];
            $this->orders = $this->db->query("SELECT * FROM (SELECT * FROM orders_archive WHERE user_id != 223 AND creation_time > '2018-01-01 00:00:00' UNION SELECT * FROM orders WHERE user_id != 223 AND creation_time > '2018-01-01 00:00:00') b ORDER BY creation_time DESC")->all();
            $this->years = $this->db->query("SELECT creation_time FROM (SELECT * FROM orders_archive WHERE user_id != 223 UNION SELECT * FROM orders WHERE user_id != 223) b GROUP BY YEAR(creation_time) ORDER BY creation_time DESC")->all();
            foreach ($this->orders as $order){
                if($order['ship_status'] == 'created' || $order['ship_status'] == 'not_paid')
                    array_push($this->orders_created, $order);
                elseif ($order['ship_status'] == 'paid')
                    array_push($this->orders_paid, $order);
                elseif ($order['ship_status'] == 'shipping')
                    array_push($this->orders_shipping, $order);
                elseif ($order['ship_status'] == 'delivered')
                    array_push($this->orders_delivered, $order);
                elseif (/*!is_null($order['cancel_time']) && */$order['ship_status'] == 'closed')
                    array_push($this->orders_cancelled, $order);
                else
                    array_push($this->orders_indefined, $order);
            }
//            $this->orders_indefined = $this->db->query("SELECT * FROM (SELECT * FROM orders_archive WHERE user_id != 223 AND ship_status != 'delivered' AND ship_status != 'created' AND ship_status != 'paid' AND ship_status != 'shipping' AND ship_status != 'closed' AND  ship_status != 'not_paid' AND cancel_time IS NULL UNION SELECT * FROM orders WHERE user_id != 223 AND ship_status != 'delivered' AND ship_status != 'created' AND ship_status != 'paid' AND ship_status != 'shipping' AND ship_status != 'closed' AND  ship_status != 'not_paid' AND cancel_time IS NULL) b ORDER BY creation_time DESC")->all();
            $arr['category'] = [];
            foreach($this->years as $year){
                if(substr($year['creation_time'], 0, 4) > 2017)
                    $arr['category'][] = substr($year['creation_time'], 0, 4);
            }

            $arr['data'] = [];
            foreach($arr['category'] as $year) {
                $orders = [];
                $i = 0;
                while($i < count($arr['category'])){
                    foreach ($this->orders as $order) {
                        if (substr($order['creation_time'], 0, 4) == substr($year, 0, 4))
                            $orders[] = $order['id'];
                    }
                    $arr['data'][$i] = count($orders);
                    $i++;
                }
            }

            $arr['data_not_paid'] = [];
            foreach($arr['category'] as $year) {
                $orders = [];
                $i = 0;
                while($i < count($arr['category'])){
                    foreach ($this->orders_created as $order) {
                        if (substr($order['creation_time'], 0, 4) == substr($year, 0, 4))
                            $orders[] = $order['id'];
                    }
                    $arr['data_not_paid'][$i] = count($orders);
                    $i++;
                }
            }

            $arr['data_paid'] = [];
            foreach($arr['category'] as $year) {
                $orders = [];
                $i = 0;
                while($i < count($arr['category'])){
                    foreach ($this->orders_paid as $order) {
                        if (substr($order['creation_time'], 0, 4) == substr($year, 0, 4))
                            $orders[] = $order['id'];
                    }
                    $arr['data_paid'][$i] = count($orders);
                    $i++;
                }
            }

            $arr['data_shipping'] = [];
            foreach($arr['category'] as $year) {
                $orders = [];
                $i = 0;
                while($i < count($arr['category'])){
                    foreach ($this->orders_shipping as $order) {
                        if (substr($order['creation_time'], 0, 4) == substr($year, 0, 4))
                            $orders[] = $order['id'];
                    }
                    $arr['data_shipping'][$i] = count($orders);
                    $i++;
                }
            }

            $arr['data_delivered'] = [];
            foreach($arr['category'] as $year) {
                $orders = [];
                $i = 0;
                while($i < count($arr['category'])){
                    foreach ($this->orders_delivered as $order) {
                        if (substr($order['creation_time'], 0, 4) == substr($year, 0, 4))
                            $orders[] = $order['id'];
                    }
                    $arr['data_delivered'][$i] = count($orders);
                    $i++;
                }
            }

            $arr['data_cancelled'] = [];
            foreach($arr['category'] as $year) {
                $orders = [];
                $i = 0;
                while($i < count($arr['category'])){
                    foreach ($this->orders_cancelled as $order) {
                        if (substr($order['creation_time'], 0, 4) == substr($year, 0, 4))
                            $orders[] = $order['id'];
                    }
                    $arr['data_cancelled'][$i] = count($orders);
                    $i++;
                }
            }

            $arr['data_indefined'] = [];
            foreach($arr['category'] as $year) {
                $orders = [];
                $i = 0;
                while($i < count($arr['category'])){
                    foreach ($this->orders_indefined as $order) {
                        if (substr($order['creation_time'], 0, 4) == substr($year, 0, 4))
                            $orders[] = $order['id'];
                    }
                    $arr['data_indefined'][$i] = count($orders);
                    $i++;
                }
            }

            $this->setJSON($arr);

        } else {
            $data = null;
            $this->result = $data;
        }
    }

    public function setJSON($value) {
        $value = json_encode($value);
        $this->result = $value;
    }

   public function getResult() {

      return $this->result;
   }

}

$app = new App();
$data = $app->getResult();

die($data);