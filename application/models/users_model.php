<?php
    class users_model extends CI_model{
        
        public function login($username, $password){
            $search_user = "CALL search_user(?,?)";
            $data = array(
                'username' => $username,
                'password' => $password
            );

            $query = $this->db->query($search_user, $data);

            if($query->num_rows() > 0){
                $row = $query->row_array();
                return $row['ID'];
            }

            return FALSE;
        }

        public function send_mail($status, $note){
            $query = $this->db->query("SELECT * FROM email WHERE status = '".$status."' LIMIT 1");
            $row = $query->row_array();
            
            $config = array();
            $config['protocol'] = 'smtp';
            $config['smtp_host']    = 'ssl://smtp.gmail.com';
            $config['smtp_user']    = '[email]';
            $config['smtp_pass']    = '[password]';
            $config['smtp_timeout'] = '60';
            $config['smtp_port'] = 465;
            $this->email->initialize($config);
            $this->email->set_newline("\r\n");

            $row['Subject'] = "[".strtoupper($status)."]".$row['Subject'];
            $this->email->subject($row['Subject']);

            $row['Body'] = str_replace("[NOTE]", $note, $row['Body']);
            // Replace with request details
            // $row['Body'] = str_replace("[ENV]", $env, $row['Body']);
            // $row['Body'] = str_replace("[TIMESTAMP]", $timeStamp, $row['Body']);
            // $row['Body'] = str_replace("[EXPORTLIST]", $exportList, $row['Body']);
            // $row['Body'] = str_replace("[LINK]", $link, $row['Body']);
            $this->email->message($row['Body']);
            
            $this->email->to($row['ReceiverEmail']);
            $this->email->from($row['SenderEmail'], $row['SenderName']);

            // send email
            // if($this->email->send()){
            //     echo "Email has been sent.";
            // } else {
            //     echo $this->email->print_debugger();
            // }
        }
    }