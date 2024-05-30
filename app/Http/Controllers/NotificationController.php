<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DateTime;
use onesignal\client\api\DefaultApi;
use onesignal\client\Configuration;
use onesignal\client\model\GetNotificationRequestBody;
use onesignal\client\model\Notification;
use onesignal\client\model\StringMap;
use onesignal\client\model\Player;
use onesignal\client\model\UpdatePlayerTagsRequestBody;
use onesignal\client\model\ExportPlayersRequestBody;
use onesignal\client\model\Segment;
use onesignal\client\model\FilterExpressions;
use PHPUnit\Framework\TestCase;
use onesignal;
use GuzzleHttp;

use Illuminate\Support\Facades\Validator;
use App\Models\Customer;

class NotificationController extends Controller
{
    public function sendNotification(Request $request, $idCustomer)
    {
        $validator = Validator::make($request->all(), [
            'header' => 'required',
            'message' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'data' => $validator->errors()
            ], 400);
        }

        $config = Configuration::getDefaultConfiguration()
            ->setAppKeyToken(env('ONESIGNAL_REST_API_KEY'));

        $apiInstance = new DefaultApi(
            new GuzzleHttp\Client(),
            $config
        );

        $content = new StringMap();
        $content->setEn($request->message);

        $header = new StringMap();
        $header->setEn($request->header);

        $notification = new Notification();
        $notification->setAppId(env('ONESIGNAL_APP_ID'));
        $notification->setHeadings($header);
        $notification->setContents($content);
        $notification->setIncludeExternalUserIds([$idCustomer]);

        $result = $apiInstance->createNotification($notification);

        return response()->json([
            'success' => true,
            'message' => 'Notification sent successfully',
            'data' => $result
        ], 200);
    }
}
