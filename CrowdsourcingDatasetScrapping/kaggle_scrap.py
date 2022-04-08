from bs4 import BeautifulSoup
from urllib.request import HTTPSHandler, Request, urlopen
from urllib.error import HTTPError
import re, string
import traceback
import json
from contextlib import closing
from selenium.webdriver import Firefox # pip install selenium
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.common.by import By
from selenium.webdriver.support import expected_conditions as EC, select
from selenium.webdriver.support.ui import Select
from selenium.webdriver.chrome.options import Options
from selenium.webdriver.common.action_chains import ActionChains
from selenium import webdriver
from webdriver_manager.firefox import GeckoDriverManager
import csv
import os
import errno
import calendar
import random
import ast
from urllib.parse import unquote
import time

url = "https://www.kaggle.com/meetnagadia/collection-of-different-category-of-leaf-images"
baseSite = "https://www.kaggle.com/datasets"

options = Options()
options.add_argument('--headless')
options.add_argument('--disable-gpu')
driver = webdriver.Chrome('./chromedriver', options=options)

links = ['test1', 'test2']
with open('test.csv', 'w', newline='') as output_file:
    # dict_writer = csv.DictWriter(output_file, keys)
    # dict_writer.writeheader()
    writer = csv.writer(output_file)
    writer.writerow(links)
    # writer.writerows(links) 

driver.get(baseSite)

page_source = driver.page_source
soup = BeautifulSoup(page_source, 'html.parser')

test = soup.find('button', string="Explore all")
test = soup.find('button', string="Explore all public datasets")
butts = soup.findAll('button', { 'class': 'HuzNs'})
buttons = driver.find_elements_by_css_selector("button.HuzNs")

driver.execute_script("arguments[0].click();", buttons[-1])
time.sleep(5)

WebDriverWait(driver, 10)
page_source = driver.page_source
soup = BeautifulSoup(page_source)
links = []
for i in range(1000):
    time.sleep(5)
    page_source = driver.page_source
    soup = BeautifulSoup(page_source)
    dataList = soup.find('ul', {'class': ['km-list--three-line']})
    for el in dataList:
        a_tag = el.a
        link = a_tag['href']
        links.append(link)
        print(f'link: {link}')
    nextPage = driver.find_element_by_css_selector("[title*='Next Page']")
    driver.execute_script("arguments[0].click();", nextPage)
    if(i == 500):
        with open('halfLinks.csv', 'w', newline='') as output_file:
            writer = csv.writer(output_file)
            writer.writerow(links)

with open('wholeLinks.csv', 'w', newline='') as output_file:
    writer = csv.writer(output_file)
    writer.writerow(links)

print('finished')
