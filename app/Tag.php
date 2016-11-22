<?php

namespace MagicMirror;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['name'];

    public function categories() {
        return $this->belongsToMany('MagicMirror\Module');
    } 

    public static function getOrCreate($tags) {
        if (count($tags)==0) {
            return collect([]);
        }

        $tagsInDatabase = Tag::whereIn('name', $tags)->get();

        $missingTags = collect($tags)->filter(function($tag) use ($tagsInDatabase) {
            return !$tagsInDatabase->pluck('name')->contains($tag);
        })->each(function($tag) use  (&$tagsInDatabase) {
            $tagsInDatabase->push(Tag::create(["name" => $tag]));
        });

        return $tagsInDatabase;
    }
}
