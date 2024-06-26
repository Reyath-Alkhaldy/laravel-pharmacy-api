<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Trait\GetUser;
use Illuminate\Http\Request;

class FirbaseController extends Controller
{
    use GetUser;

    public $FCMTokenDevice = "cFHksAaTTK6iIwTALROCEd:APA91bH9_hEPuDjrvuLiCK6cQDXiL_2huQj4oRQ0ETBmeGUx7EWzsbY97q7hM2nuRiJbYcLZ-2vapD3MYxQXbjSVYGCQQYMrpyw-4SZ1wbGtuXHCS5EpAuUfLnct5YQv4TmtWh0AwCDD";
    public $Authorization = 'Bearer ya29.c.c0AY_VpZiAKfNLewLIHlDJBesF35crDO-LS_MGhnLQ2UNbpO1XuGY_LGZc6L1HqQDATKnRi8Pdz0gCR5-zn3bRkBI2tYZliNhNUDMdGaVt9KcwTn9nrvXfS06VGYA1-F25_BRr0JKg3ZUcBYbPbKu8D6Mz79fUWo5UaY6_UwAzFoygylc84PnIJi4E_WluJQRYSU__7nx3YgM6J6lF1M93hBVJCNq8DkE_DbExdxbm7vQOweYC8lTMH9P8zTaa75ogRrZkluvzXhmtvIYia5hx04LJcLsSArSzsnxnreDUWqKVVHxWkCN1o1qBWf_E5iM_fVN6oINebILDZvZUxGyzR_1HVrjNV7MBrZFOMDXwf11a3qCjiD91Br0oqwE387Kusq-9XiWZ9VzJlFFcVO2Y7XVV4B85wiByZOrgqb0wpO7sqrq9I7hO7JSaIxUgOrhqjZo0UhVgk56oJxV3o6q6BwrjfQtQnulY-hZ8eSV4VwuFXic-1ibX0_4J4j5gaeQ_9ajgUQl44qSzJYOw_RbsnOaWf73ektR3MUR680wQ7_fzj1UgSuYWlQ7hM8JIiiSgWgbdRhIcnk8c_14_bwgQWw-XjpX7lBXzlhaqMBBlwdm24wS3gxgW0k6awyxiuWoxkth59n9uzkf6ViJjRc_26mqd8ZxawoQwXpnQxvRrwVMMUnjzx4fXld43lfnWemurjexsg1frBl9IJO-spM8UBWseYJVvlXIlbxV9M9krViZ3m6Ysxbck70WUvnlqSt1badwB7mefZjq_ljIsQdznd-2yn3qyvWd9tUVq2rBe52mwj1z_bjyXdnRe42yx5UZVu-r0x9njoUrbikfBuXxQxze_OObQn-JkVwiXVBf3vgXcxsm6W7BZcibFUFBcnXUhxznghnMYQmlcJp32n2_rnwmUIiW5jk8_Wlij5Un1zuec7qSwig6nBia8y6z9-Mkv4o1hSFsOliWJnYr_UvOOw3ubU__V4okniRk7JalJods9u';
    public $CURLOPT_URL = 'https://fcm.googleapis.com/v1/projects/admin-and-pharmacy/messages:send';
    public $CURLOPT_POSTFIELDS = '';
    public function index()
    {
        return $this->sendNotifyByFCMTokendevice($this->FCMTokenDevice);
    }
    public function firebase()
    {
        $this->CURLOPT_POSTFIELDS = ' {
            "message":{
               "token":"' . $this->FCMTokenDevice . '",
               "notification":{
                 "body":"This is an FCM notification message!",
                 "title":"FCM Message"
               },
               "data": {
               "story_id": "story_12345"
             },
            }    
         }';
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL =>  $this->CURLOPT_URL,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>  $this->CURLOPT_POSTFIELDS,
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                'Content-Type: application/json',
                'Authorization: ' . $this->Authorization
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }
}
