<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Timeline;
use Carbon\Carbon;

class TimelineController extends Controller
{
    /**
     * 
     */
    public function getTimeline()
    {
        

        $timelines = Timeline::whereHas('friend', function($query){
            return $query->whereUserId(auth()->id());
        })->orderBy('id', 'desc')->limit(30)->get();

        if (!$timelines->count()) {
            $timeline = $this->getOrCreateFirstNotification();
            $timelines->push($timeline);
        }

        $daysTimelines = $timelines->transform(function($item){
            $item->days = $item->created_at->diff(Carbon::now())->days;
            return $item;
        })->groupBy('days');

    	return view('timeline.main', [
            'daysTimelines' => $daysTimelines
        ]);
    }

    /**
     * 
     */
    public function getOrCreateFirstNotification() 
    {
        Timeline::whereProvider('notifier')->delete();
        return Timeline::firstOrCreate([
            'friend_id' => '0',
            'avatar_image' => url('images/service.jpg'),
            'attached_photo' => url('images/main.jpg'),
            'provider' => 'notifier',
            'page_url' => action('TimelineController@getTimeline'),
            'description' => _('Вітаємо в системі SocialNotifier!!! Це ваше перше сповіщення:) <br><br> Тут ви зможете переглядати сповіщення про оновлення ваших друзів, на яких ви підписалися. <br> Для початку роботи з сервісом, налаштуйте свій профіль та добавте хоча б одного друга. <hr> Для зручності, рекомендуємо налаштувати свій аккаунт Viber. Так ви зможете отримувати сповіщення в реальному часі на ваш смартфон. Для того щоб налаштувати свій аккаунт Viber, перейдіть до налаштувань у свому профілі.'),
        ]);
    }
}
