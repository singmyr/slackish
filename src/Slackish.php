<?php
/**
 * User: Mattias Singmyr
 * Date: 21/06/16
 * Time: 22:57
 */

namespace Singmyr\Slackish;

class Slackish {
    /**
     * @var string
     */
    protected $_url = null;

    protected $_channel     = null;
    protected $_username    = null;
    protected $_text        = null;
    protected $_attachments = [];

    public function __construct($url = null) {
        if($url) {
            $this->_url = $url;
        }
    }

    protected function _build() {
        $data = [];

        if($this->_channel) {
            $data['channel'] = $this->_channel;
        }

        if($this->_text) {
            $data['text'] = $this->_text;
        }

        if($this->_username) {
            $data['username'] = $this->_username;
        }

        if(!empty($this->_attachments)) {
            $data['attachments'] = $this->_attachments;
        }

        return $data;
    }

    public function send() {
        if(!$this->_url != '') {
            echo "nope1";
            return false;
        }

        $data = $this->_build();
        if($data === false) {
            echo "nope2";
            return false;
        }

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $this->_url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);

        $result = curl_exec($curl);

        // @todo: Evaluate $result.

        curl_close($curl);

        return true;
    }

    public function setURL($url) {
        $this->_url = $url;
    }

    public function setChannel($channel) {
        $this->_channel = $channel;

        return $this;
    }

    public function setUsername($username) {
        $this->_username = $username;

        return $this;
    }

    public function setText($text) {
        $this->_text = $text;

        return $this;
    }

    public function addAttachment(array $attachment) {
        $this->_attachments[] = $attachment;

        return $this;
    }
}