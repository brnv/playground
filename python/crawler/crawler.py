import scrapy

class Spider(scrapy.Spider):

    name = 'anyrandomname'

    base_url = 'http://bodymaster.sportbox.ru/exercises/?PAGEN_1='

    def start_requests(self):
        for page_num in range(78):
            exercises_page_url = self.base_url + str(page_num)
            yield scrapy.Request(
                    exercises_page_url, callback=self.parse_exercises_list_page)

    def parse_exercises_list_page(self, response):
        for href in response.css('span.apblTitle1 a::attr(href)'):
            full_url = response.urljoin(href.extract())
            yield scrapy.Request(full_url, callback=self.parse_exercise)

    def parse_exercise(self, response):
        yield {
            'title': response.css('h1.olTitle1::text').extract()[0],
            'link': response.url,
            'description': response.css('div.olRule p::text').extract()[0],
            'images': response.css('div.olnPics img::attr(src)').extract()
        }
