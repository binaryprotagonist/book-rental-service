<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Book;
use App\Models\Rent;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');
        $books = Book::where('title', 'like', '%' . $query . '%')
            ->orWhere('genre', 'like', '%' . $query . '%')
            ->get();
        return response()->json($books);
    }

    public function rentBook(Request $request, $book_id)
    {
        $book = Book::findOrFail($book_id);
        $user_id = $request->user()->id;
        $rent = Rent::create([
            'book_id' => $book->id,
            'user_id' => $user_id,
            'rent_date' => Carbon::now()
        ]);
        return response()->json([
            'message' => 'Book rented successfully!',
            'rent' => $rent
        ], 201);
    }

    public function returnBook(Request $request, $book_id)
    {
        $user_id = $request->user()->id;
        $rent = Rent::where('book_id',$book_id)
                        ->where('user_id',$user_id)
                        ->first();
        $rent->update([
            'return_date' => Carbon::now(),
        ]);
        return response()->json([
            'message' => 'Book returned successfully!',
            'rent' => $rent
        ]);
    }

    public function rentalHistory(Request $request)
    {
        $rentalHistory = Rent::where('user_id', $request->user()->id)
            ->with('book')
            ->orderBy('rent_date', 'desc')
            ->get();
        return response()->json([
            'rental_history' => $rentalHistory,
        ]);
    }

    public function bookStatistics()
    {
        $mostOverdueBook = Rent::select('book_id', DB::raw('DATEDIFF(NOW(), overdue_date) as overdue_days'))
            ->whereNotNull('overdue_date')
            ->whereNull('return_date')
            ->orderByDesc('overdue_days')
            ->first();

        if ($mostOverdueBook) {
            $mostOverdueBook = Book::find($mostOverdueBook->book_id);
        }

        $mostPopularBook = Rent::select('book_id', DB::raw('count(*) as rent_count'))
            ->groupBy('book_id')
            ->orderByDesc('rent_count')
            ->first();

        if ($mostPopularBook) {
            $mostPopularBook = Book::find($mostPopularBook->book_id);
        }

        $leastPopularBook = Rent::select('book_id', DB::raw('count(*) as rent_count'))
            ->groupBy('book_id')
            ->orderBy('rent_count')
            ->first();

        if ($leastPopularBook) {
            $leastPopularBook = Book::find($leastPopularBook->book_id);
        }

        return response()->json([
            'most_overdue_book' => $mostOverdueBook,
            'most_popular_book' => $mostPopularBook,
            'least_popular_book' => $leastPopularBook,
        ]);
    }

}
