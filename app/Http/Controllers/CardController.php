<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCardRequest;
use App\Http\Requests\UpdateCardRequest;
use App\Http\Resources\CardResource;
use App\Models\Card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $date = $request->query('date');
        $status = $request->query('status');

        $cards = Card::query()
            ->when($date, function ($query, $date){
                $query->whereDate('created_at', $date);
            })
            ->when(blank($status), function ($query, $status){
                $query->withTrashed();
            }, function ($query) use ($status){
                if ($status == 1){
                    $query->withoutTrashed();
                } elseif ($status == 0){
                    $query->onlyTrashed();
                }
            })
            ->get();

        return CardResource::collection($cards);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCardRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCardRequest $request)
    {
        $last_position = Card::getLastPosition();
        $card = Card::create([
            ...$request->validated(),
            'position' => ($last_position ? $last_position + 1 : 1)
        ]);

        return new CardResource($card);
    }

    /**
     * @param UpdateCardRequest $request
     * @param Card $card
     * @return CardResource
     */
    public function update(UpdateCardRequest $request, Card $card)
    {
        $card->update($request->validated());
        return new CardResource($card);
    }

    public function swapPositions(Request $request)
    {
        collect($request->ordered_cards)
            ->each(
                fn($val) => Card::find($val['id'])
                ->update([
                    'position' => $val['position'],
                    'column_id' => $val['column_id'],
                ])
            );
    }
}
