<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class SendLineReminder extends Command
{
    // 💡 ターミナルから手動で動かすときのコマンド名
    protected $signature = 'line:remind';

    // コマンドの説明
    protected $description = '今日が期限のタスクをLINEに通知します';

    public function handle()
    {
        // 1. .envに書いたLINEの鍵を読み込む
        $token = env('LINE_CHANNEL_ACCESS_TOKEN');
        $userId = env('LINE_USER_ID');

        if (!$token || !$userId) {
            $this->error('LINEの通知設定が .env に登録されていません。');
            return;
        }

        // 2. データベースから「今日が期限」のタスクをすべて取得する
        $today = Carbon::today()->format('Y-m-d');
        $tasks = Task::where('due_date', '<=',now())
                    ->where('is_completed',false)
                    ->get();

        // 今日が期限のタスクが1つもない場合は、通知せずに終了する
        if ($tasks->isEmpty()) {
            $this->info('今日が期限のタスクはありませんでした。');
            return;
        }

        // 3. 送信するメッセージの文章を組み立てる
        $message = "【ADHDタスクリマインダー】\n";
        $message .= "今日が期限のタスクが " . $tasks->count() . " 件あります！\n\n";

        foreach ($tasks as $index => $task) {
            $message .= "🔔 " . ($index + 1) . ". " . $task->title . "\n";
            if ($task->description) {
                $message .= " └ " . $task->description . "\n";
            }
        }
        
        $message .= "\n視界に入れて、一つずつ片付けよう！";

        // 4. LINEのサーバーにデータを送りつける（Messaging APIの仕様に合わせた形）
        $response = Http::withToken($token)
            ->withoutVerifying()
            ->post('https://api.line.me/v2/bot/message/push', [
                'to' => $userId,
                'messages' => [
                    [
                        'type' => 'text',
                        'text' => $message
                    ]
                ]
            ]);

        // 結果の確認
        if ($response->successful()) {
            $this->info('LINEへのリマインド送信に成功しました！');
        } else {
            $this->error('LINE送信エラー: ' . $response->body());
        }
    }
}