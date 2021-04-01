<?php
 
namespace HepplerDotNet\FullTextSearch;

use \Illuminate\Database\Eloquent\Builder;

trait FullTextSearch
{
    /**
     * Replaces reserved characters with full text search wildcards
     *
     */
    protected function fullTextWildcards(String $term): String
    {
        // removing symbols used by MySQL
        $reservedSymbols = ['-', '+', '<', '>', '@', '(', ')', '~','*','%'];
        $term = str_replace($reservedSymbols, '', $term);
 
        $words = explode(' ', $term);
 
        foreach($words as $key => $word) {
            /*
             * applying + operator (required word) only big words
             * because smaller ones are not indexed by mysql
             */
            if(strlen($word) >= 3) {
                $words[$key] = '+' . $word . '*';
            }
        }
 
        $searchTerm = implode( ' ', $words);
 
        return $searchTerm;
    }
 
    /**
     * Scope a query that matches a full text search of term.
     *
     */
    public function scopeSearch(Builder $query, String $term): Builder
    {
        $columns = implode(',',$this->searchable);
 
        return $query->whereRaw("MATCH ({$columns}) AGAINST (? IN BOOLEAN MODE)" , $this->fullTextWildcards($term));
    }
}