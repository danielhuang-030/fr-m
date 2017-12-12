<?php

namespace App\Http\Controllers\Home;

use DB;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BooksController extends Controller
{
    public function index(Request $request)
    {
        $model = new \App\Models\Book();
//        $book = $model->orWhereHas('authors', function($query) {
//            $query->where('name', 'like', 'jeff%');
//        })->orWhereHas('categories', function($query) {
//            $query->where('slug', 'like', 'childrenss%');
//        })->first();
//        dd($book);

//        $book = $model->with(['conditions' => function($query) {
//            $query->where('condition', '=', 'new');
//        }])->first()->conditions()->first();
//        dd($book);

        $book = $model->with(['authors' => function($query) {
            $query->where('name', 'like', 'jeff%');
        }])->first();
        dd($book);

        // dd(\App\Models\Category::find(1)->children()->get());

        // dd($book->conditions()->get());

        // $this->setExample();
        // $this->dropExample();

    }

    public function author($slug) {
        // author
        $model = new \App\Models\Author();
        $author = $model->where('slug', '=', $slug)->first();

        // books
        $model = new \App\Models\Book();
        $books = $model->whereHas('authors', function($query) use (&$slug) {
            $query->where('slug', $slug);
        })->with('images', 'conditions')->get();

        dd($author, $books);
    }

    public function category($slug) {
        dd(str_slug($slug));
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword', '');
        $model = new \App\Models\Book();
        $books = $model->orWhere('title', 'like', "%{$keyword}%")->orWhereHas('authors', function($query) use (&$keyword) {
            $query->where('name', 'like', "%{$keyword}%");
        })->orWhereHas('categories', function($query) use (&$keyword) {
            $query->where('name', 'like', "%{$keyword}%");
        })->get();
            //->paginate(10);
        dd($books);

        return view('home.products.search', compact('products'));
    }

    public function show($title, $author, $isbn13)
    {
        dd($title, $author, $isbn13);
        $recommendProducts = Product::where('category_id', $product->category_id)->take(5)->get();

        return view('home.products.show', compact('product', 'recommendProducts'));
    }

    protected function guard()
    {
        return Auth::guard();
    }

    protected function setExample()
    {
        // author
        $author = 'Jeff Kinney';
        $model = new \App\Models\Author();
        $model->name = $author;
        $model->slug = str_slug($author);
        $model->save();
        $authorId = $model->id;

        $categoryIdList = [];
        $categoryStr = "Children's Books > Children's Fiction > Humorous Stories";
        $categoryList = explode(' > ', $categoryStr);
        $parentCategory = null;
        foreach ($categoryList as $name) {
            $categoryData = [
                'name' => $name,
                'slug' => str_slug($name),
            ];
            $model = new \App\Models\Category();
            $category = $model->create($categoryData);
            if (!empty($parentCategory)) {
                $category->appendToNode($parentCategory)->save();
            }
            $parentCategory = $category;
            $categoryIdList[] = $parentCategory->id;
        }

        $title = 'Diary of a Wimpy Kid';
        $model = new \App\Models\Book();
        $model->title = $title;
        $model->slug = str_slug($title);
        $model->bwb_id = 21710420;
        $model->isbn10 = '0810993139';
        $model->isbn13 = '9780810993136';
        $model->description = '"Boys dont keep diariesor do they?" <BR> "The launch of an exciting and innovatively illustrated new series narrated by an unforgettable kid every family can relate to" <BR>Its a new school year, and Greg Heffley finds himself thrust into middle school, where undersized weaklings share the hallways with kids who are taller, meaner, and already shaving. The hazards of growing up before youre ready are uniquely revealed through words and drawings as Greg records them in his diary. <BR>In book one of this debut series, Greg is happy to have Rowley, his sidekick, along for the ride. But when Rowleys star starts to rise, Greg tries to use his best friends newfound popularity to his own advantage, kicking off a chain of events that will test their friendship in hilarious fashion. <BR>Author/illustrator Jeff Kinney recalls the growing pains of school life and introduces a new kind of hero who epitomizes the challenges of being a kid. As Greg says in his diary, Just dont expect me to be all Dear Diary this and Dear Diary that. Luckily for us, what Greg Heffley says he wont do and what he actually does are two very different things. <BR>Since its launch in May 2004 on Funbrain.com, the Web version of "Diary of a Wimpy Kid" has been viewed by 20 million unique online readers. This year, it is averaging 70,000 readers a day.';
        $model->format = 'Hardcover';
        $model->weight = 0.85;
        $model->save();
        $bookId = $model->id;

        $model = new \App\Models\BookCondition();
        $model->condition = 'used';
        $model->quantity = 2;
        $model->price = 3.95;
        $model->in_stock = 1;
        $model->book_id = $bookId;
        $model->save();
        $model = new \App\Models\BookCondition();
        $model->condition = 'new';
        $model->quantity = 99;
        $model->price = 10.95;
        $model->in_stock = 1;
        $model->book_id = $bookId;
        $model->save();

        $model = new \App\Models\BookImage();
        $model->book_id = $bookId;
        $model->file = '/uploads/products/list/fd370323-8a6f-d770-dfb8-596d532dcac0.jpeg';
        $model->save();

        $model = new \App\Models\BookAuthor();
        $model->book_id = $bookId;
        $model->author_id = $authorId;
        $model->save();

        foreach ($categoryIdList as $categoryId) {
            $model = new \App\Models\BookCategory();
            $model->book_id = $bookId;
            $model->category_id = $categoryId;
            $model->save();
        }
        dd('done.');
    }

    protected function dropExample()
    {
        DB::table('book_categories')->truncate();
        DB::table('book_images')->truncate();
        DB::table('book_conditions')->truncate();
        DB::table('books')->truncate();
        DB::table('categories')->truncate();
        DB::table('authors')->truncate();
        dd('droped.');
    }

}
