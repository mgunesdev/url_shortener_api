<?php

namespace App\Console\Commands;

use App\Models\Url;
use App\Models\User;
use App\Notifications\SendEmail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class JobDailyReminderVisits extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'job:reminder-visits';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Log::channel('command')->info("JOB - job:reminder-visits STARTED!");

        try {
            $this->reportProcess();
        } catch (\Exception $exception) {
            Log::channel('command')->error("JOB - job:reminder-visits - Error Because : " . $exception->getMessage());
        }

        Log::channel('command')->info("JOB - job:reminder-visits ENDED!");

        return Command::SUCCESS;
    }

    private function reportProcess()
    {
        $data = [];
        $users = User::all();

        foreach ($users as $user) {
            $urls = Url::where('user_id', $user->id)->get();
            if (!$urls) {
                continue;
            }
            foreach ($urls as $url) {
                $data[] = [
                    'slug' => $url->slug,
                    'link' => $url->link,
                    'visit_count' => $url->visitCount(),
                ];
            }

            Notification::send($user, new SendEmail($data));
        }

    }

    /**
     * @param $meeting
     * @return string
     */
    private function getReminderMessage($meeting): string
    {
        $subject = $meeting->getMeetingSubject();
        $teacher = $meeting->getMeetingTeacher();
        $period = $meeting->getMeetingPeriodHour();
        return sprintf(
            'Your online meeting on %s with %s at %s is approaching.',
            $subject['name'], $teacher['name_surname'], $period['hour']
        );
    }

    /**
     * @param $meeting
     * @return string
     */
    private function getReminderTitle($meeting): string
    {
        return 'Randevu Hatırlatma';
    }
}
