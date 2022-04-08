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
import subprocess
import errno
import calendar
import random
import ast
from urllib.parse import unquote
import time

url = "https://www.kaggle.com/meetnagadia/collection-of-different-category-of-leaf-images"
baseSite = "https://www.kaggle.com/"

links = []
with open('halfLinks.csv', 'r') as f:
    # dict_writer = csv.DictWriter(output_file, keys)
    # dict_writer.writeheader()
    reader = csv.reader(f)
    for row in reader:
        for v in row:
            links.append(v[1:])
      
datasetInfo = []
count = 0
for link in links:
    out = subprocess.run(['kaggle', 'datasets', 'metadata', link], capture_output=True)
    time.sleep(1)
    if('404' in str(out.stdout)):
        continue
    with open('dataset-metadata.json', 'r') as f:
        data = json.load(f)
    
    dataInfoObject = {
        "url": baseSite+link,
        "title": data['title'],
        "keywords": data['keywords'],
        "license": [x['name'] for x in data['licenses']],
        "usabilityRating": data['usabilityRating'],
        "totalViews":  data['totalViews'],
        "totalDownloads": data['totalDownloads'],
        "totalVotes": data['totalVotes'],
        "description": data['description']
    }
    datasetInfo.append(dataInfoObject)
    count += 1
    if(count % 100 == 0):
        print(f'count: {count}')
        keys = datasetInfo[0].keys()
        with open('kaggle_datasets.csv', 'w', encoding="utf-8", newline='') as output_file:
            dict_writer = csv.DictWriter(output_file, keys)
            dict_writer.writeheader()
            dict_writer.writerows(datasetInfo)
