<?php

class MauPedia
{
    private $id;
    private $key;
    private $secret;

    public function __construct($id, $key, $secret)
    {
        $this->id = $id;
        $this->key = $key;
        $this->secret = $secret;
    }

    public function profile()
    {
        $try = $this->connect('profile');
        return [
            'result' => $try['result'],
            'data' => $try['result'] == false ? '' : $try['data'],
            'message' => $try['result'] == false ? $try['message'] : 'Successfully got your account details.'
        ];
    }

    public function order($x, $data)
    {
        if (in_array($x, ['prabayar', 'pascabayar', 'socmed', 'game']) && is_array($data)) {
            $data['type'] = 'order';
            if ($x == 'prabayar') $try = $this->connect('prepaid', $data);
            if ($x == 'pascabayar') $try = $this->connect('postpaid', $data);
            if ($x == 'socmed') $try = $this->connect('social-media', $data);
            if ($x == 'game') $try = $this->connect('game-feature', $data);
            $msg = $try['result'] == false ? $try['message'] : '';
            return [
                'result' => $try['result'],
                'data' => $try['result'] == false ? '' : $try['data'],
                'message' => isset($try['message']) ? $try['message'] : $msg
            ];
        } else {
            return ['result' => false, 'data' => null, 'message' => 'Invalid Request!'];
        }
    }

    public function status($x, $id)
    {
        if (in_array($x, ['prabayar', 'pascabayar', 'socmed', 'game']) && !empty($id)) {
            if ($x == 'prabayar') $try = $this->connect('prepaid', ['type' => 'status', 'trxid' => $id]);
            if ($x == 'pascabayar') $try = $this->connect('postpaid', ['type' => 'status', 'trxid' => $id]);
            if ($x == 'socmed') $try = $this->connect('social-media', ['type' => 'status', 'trxid' => $id]);
            if ($x == 'game') $try = $this->connect('game-feature', ['type' => 'status', 'trxid' => $id]);
            $msg = $try['result'] == false ? $try['message'] : 'Detail transaksi berhasil didapatkan.';
            return [
                'result' => $try['result'],
                'data' => $try['result'] == false ? '' : $try['data'],
                'message' => isset($try['message']) ? $try['message'] : $msg
            ];
        } else {
            return ['result' => false, 'data' => null, 'message' => 'Invalid Request!'];
        }
    }

    public function services($x)
    {
        if (in_array($x, ['prabayar', 'pascabayar', 'socmed', 'game'])) {
            if ($x == 'prabayar') $try = $this->connect('prepaid', ['type' => 'services']);
            if ($x == 'pascabayar') $try = $this->connect('postpaid', ['type' => 'services']);
            if ($x == 'socmed') $try = $this->connect('social-media', ['type' => 'services']);
            if ($x == 'game') $try = $this->connect('game-feature', ['type' => 'services']);
            return [
                'result' => $try['result'],
                'data' => $try['result'] == false ? '' : $try['data'],
                'message' => $try['result'] == false ? $try['message'] : 'Daftar layanan berhasil didapatkan.'
            ];
        } else {
            return ['result' => false, 'data' => null, 'message' => 'Invalid Request!'];
        }
    }

    public function deposit($x, $data = '')
    {
        if (in_array($x, ['request', 'status', 'cancel', 'method'])) {
            if ($x == 'request' && is_array($data)) {
                $try = $this->connect('deposit', array_merge(['type' => 'request'], $data));
                return [
                    'result' => $try['result'],
                    'data' => $try['result'] == false ? '' : $try['data'],
                    'message' => $try['result'] == false ? $try['message'] : 'Deposit Request successfully made.'
                ];
            }
            if ($x == 'status') {
                $arr = !empty($data) ? ['type' => 'status', 'trxid' => $data] : ['type' => 'status'];
                $try = $this->connect('deposit', $arr);
                return [
                    'result' => $try['result'],
                    'data' => $try['result'] == false ? '' : $try['data'],
                    'message' => $try['result'] == false ? $try['message'] : 'Deposit data checked successfully.'
                ];
            }
            if ($x == 'cancel' && !empty($data)) {
                $try = $this->connect('deposit', ['type' => 'cancel', 'trxid' => $data]);
                return ['result' => $try['result'], 'data' => $try['data'], 'message' => $try['message']];
            }
            if ($x == 'method') {
                $try = $this->connect('deposit', ['type' => 'method']);
                return [
                    'result' => $try['result'],
                    'data' => $try['result'] == false ? '' : $try['data'],
                    'message' => $try['result'] == false ? $try['message'] : 'Deposit method successfully obtained.'
                ];
            } else {
                return ['result' => false, 'data' => null, 'message' => 'Invalid Request!'];
            }
        } else {
            return ['result' => false, 'data' => null, 'message' => 'Invalid Request!'];
        }
    }

    # END POINT CONNECTION #

    public function connect($x, $data = [], $reqout = 'decode')
    {
        $end_point = 'https://api.maupedia.com/v1/' . $x;
        $data['key'] = $this->key;
        $data['sign'] = sha1($this->id . $this->key);
        $data['secret'] = $this->secret;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $end_point);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $chresult = curl_exec($ch);
        curl_close($ch);
        return ($reqout == 'decode') ? json_decode($chresult, true) : $chresult;
    }
}
