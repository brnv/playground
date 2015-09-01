import scrapy

class PumpIronCrawler(scrapy.Spider):

    name = 'anyrandomname'

    start_urls = [
        'http://pumpiron.ru/exercize/muscle/biceps',
        'http://pumpiron.ru/exercize/muscle/grud',
        'http://pumpiron.ru/exercize/muscle/ikry',
        'http://pumpiron.ru/exercize/muscle/nogi',
        'http://pumpiron.ru/exercize/muscle/plechi',
        'http://pumpiron.ru/exercize/muscle/predplechya',
        'http://pumpiron.ru/exercize/muscle/press',
        'http://pumpiron.ru/exercize/muscle/spina',
        'http://pumpiron.ru/exercize/muscle/trapeciya',
        'http://pumpiron.ru/exercize/muscle/triceps',
        'http://pumpiron.ru/exercize/muscle/sheya',
        'http://pumpiron.ru/exercize/muscle/yagodicy',
    ]

    def parse(self, response):
        for page_num in range(3):
            exercises_page_url = response.urljoin('?page=' + str(page_num))
            yield scrapy.Request(
                    exercises_page_url, callback=self.parse_exercises_list_page)

    def parse_exercises_list_page(self, response):
        for href in response.css('h2.exercize_group_title a::attr(href)'):
            full_url = response.urljoin(href.extract())
            yield scrapy.Request(full_url, callback=self.parse_exercise)

    def parse_exercise(self, response):
        yield {
            'name': response.css('h1.content_title::text').extract(),
            'rules': response.css('div.field-type-text-with-summary div.field-item p::text').extract(),
            'images': response.css('div.field-type-image img::attr(src)').extract(),
            'inventory': response.css('div.view-display-id-exercize_stock div.stock-title a::text').extract(),
            'muscles_additional': response.css('div.view-display-id-muscle_sub a::text').extract(),
            'muscles_primary': response.css('div.view-display-id-muscle_base a::text').extract(),
            'muscles_group': response.css('div.field-name-field-muscle-group div.field-item a::text').extract(),
            'link': response.url,
        }
