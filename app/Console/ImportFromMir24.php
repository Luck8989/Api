<?php

namespace App\Console\Commands;

use App\Library\Services\Import\Mir24Importer;
use Illuminate\Console\Command;

class ImportFromMir24 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:mir24';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import tables from mir24';


    private $importer;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Mir24Importer $importer)
    {
        parent::__construct();
        $this->importer = $importer;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->importer->setUpdateComplete(false);
// TODO INSERT INTO `status` VALUES (1,'UPDATE_COMPLETE',1,NULL,NULL);

        $this->info("Starting update.");

//        $this->info("Getting categories.");
//        $categories = $this->importer->getCategories();
//        $this->info("Got " . count($categories) . " categories. Saving...");
//        $this->importer->updateCategories($categories);

        $this->info("Getting news.");
        $news = $this->importer->getLastNews();
        $this->info("Got " . count($news) . " news. Saving...");
        $this->importer->saveLastNews($news);

        $this->info("Getting actual news info.");
        $actualNews = $this->importer->getActualNewsId();
        $this->info("Got " . count($actualNews) . " hits. Saving...");
        $this->importer->updateActualNews($actualNews);

        $this->info("Getting tags.");
        $tags = $this->importer->getTags();
        $this->info("Got " . count($tags) . " tags. Saving...");
        $this->importer->saveTags($tags);

        $this->info("Getting news tags info.");
        $newsTags = $this->importer->getNewsTags($news);
        $this->info("Got " . count($newsTags) . " news tags info. Saving...");
        $this->importer->saveNewsTags($newsTags);

        $this->info("Getting photos for news with galleries.");
        $galleries = $this->importer->getGalleries($news);
        $this->info("Got " . count($galleries) . " galleries. Saving...");
        $this->importer->saveGalleries($galleries);

//        $this->info("Getting countries.");
//        $countries = $this->importer->getCountries();
//        $this->info("Got " . count($countries) . " countries. Saving...");
//        $this->importer->saveCountries($countries);

        $this->info("Getting country links.");
        $links = $this->importer->getNewsCountryLinks($news);
        $this->info("Got " . count($links) . " links. Saving...");
        $this->importer->saveNewsCountryLinks($links);

        # TODO Setting to cache:
//        $this->info("Setting last news to cache.");
//        $getter = new InfoGetter();
//        NewsOptions options = new NewsOptions();
//        options.setLastNews(Boolean.TRUE);
//        options.setLimit(10);
//        options.setPage(1);
//        ArrayList<NewsItem> lastNews = getter.getLastNews(options);
//        context.setAttribute("lastNews", lastNews);
//        $this->info("Setting last news with gallery to cache.");
//        options.setOnlyWithGallery(Boolean.TRUE);
//        ArrayList<NewsItem> newsWithGallery = getter.getLastNews(options);
//        context.setAttribute("newsWithGallery", newsWithGallery);
//        $this->info("Setting last news with videos to cache.");
//        options.setOnlyVideo(Boolean.TRUE);
//        options.setOnlyWithGallery(Boolean.FALSE);
//        ArrayList<NewsItem> newsWithVideo = getter.getLastNews(options);
//        context.setAttribute("newsWithVideo", newsWithVideo);
//        $this->info("Setting countries to cache.");
//        context.setAttribute("countries", getter.getCountries());
//        $this->info("Setting search table to cache.");
//        context.setAttribute("searchTable", getter.getSearchTable());
        $this->info("Done.");

        $this->importer->setUpdateComplete(true);
    }
}
