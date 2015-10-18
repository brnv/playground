#coding: utf-8
import scrapy
import re
from scrapy import Selector

class AtletIqCrawler(scrapy.Spider):

    name = 'anyrandomname'

    image_base_url = 'http://atletiq.com/'

    start_urls = [
        'https://atletiq.com/panel/index.php',
    ]

    def parse(self, response):
        for page_num in range(9):
            exercises_page_url = response.urljoin(
                '?obj=exercises&action=list2&ExType[]=3&page=' +
                str(page_num+1))
            yield scrapy.Request(
                exercises_page_url, callback=self.parse_exercises_list_page)

    def parse_exercises_list_page(self, response):
        for href in response.css('div.media h4 a::attr(href)'):
            full_url = response.urljoin(href.extract())
            yield scrapy.Request(full_url, callback=self.parse_exercise)

    def parse_exercise(self, response):
        try:
            muscle_primary_selector = Selector(
                text=response.css('div.profile-info-value').extract()[4])
        except Exception:
            muscle_primary_selector =  Selector(text='')
        try:
            muscle_additional_selector = Selector(
                text=response.css('div.profile-info-value').extract()[5])
        except Exception:
            muscle_additional_selector = Selector(text='')

        try:
            male_first_image = re.sub('\.\.\/', '', response.css('ul.ace-thumbnails img::attr(src)').extract()[0])
        except Exception:
            male_first_image = ''
        try:
            male_second_image = re.sub('\.\.\/', '', response.css('ul.ace-thumbnails img::attr(src)').extract()[1])
        except Exception:
            male_second_image = ''

        try:
            female_first_image = re.sub('\.\.\/', '', response.css('ul.ace-thumbnails img::attr(src)').extract()[2])
        except Exception:
            female_first_image = ''
        try:
            female_second_image = re.sub('\.\.\/', '', response.css('ul.ace-thumbnails img::attr(src)').extract()[3])
        except Exception:
            female_second_image = ''

        yield {
            'name': response.css('div.page-header h1::text').extract()[0],
            'rules': response.css('div ol li::text').extract(),
            'm': 'Растяжка',
            'mp': muscle_primary_selector.css('div::text').extract(),
            'ma': muscle_additional_selector.css('div::text').extract(),
            'url': response.url,
            't': '',
            '1m': self.image_base_url + male_first_image,
            '2m': self.image_base_url + male_second_image,
            '1w': self.image_base_url + female_first_image,
            '2w': self.image_base_url + female_second_image,
            'i': '',
        }
