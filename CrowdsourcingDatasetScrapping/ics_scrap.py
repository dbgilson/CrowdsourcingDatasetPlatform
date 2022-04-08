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

url = "https://archive.ics.uci.edu/ml/datasets.php?format=&task=&att=&area=&numAtt=&numIns=&type=&sort=nameUp&view=table"
baseSite = "https://archive.ics.uci.edu/ml/"

options = Options()

options.add_argument('--headless')
options.add_argument('--disable-gpu')
driver = webdriver.Chrome('./chromedriver', options=options)

driver.get(url)

page_source = driver.page_source
soup = BeautifulSoup(page_source, 'html.parser')

links = []
test = soup.findAll('table')

for v in test[6:6+622]:
    link = v.find('a')['href']
    links.append(link)

count = 0
datasetInfo = []
for link in links:
    try:
        driver.get(baseSite + link)
        WebDriverWait(driver, 10)
        page_source = driver.page_source
        soup = BeautifulSoup(page_source)

        # title
        title = soup.find('span', {'class': 'heading' })

        # rows, cols, type, etc 
        table = soup.findAll('table')
        datasetInfoGen = table[3].descendants
        descriptionInfo = table[1].descendants
        tmpTable = []
        for child in datasetInfoGen:
            if(child.name == 'p'):
                tmpTable.append(child.text)
        # 0 - 8  = type of data, num instances/rows, area of study, attribute char, num cols, date donated, algorithm task, missing values, num web hits.
        tmpTable = tmpTable[1::2]

        description = ""
        tmp = 0
        for child in descriptionInfo:
            if(child.name == 'p' and 'class' in child.attrs and 'normal' in child.attrs['class']):
                if(tmp > 21):
                    break
                if(tmp > 19):
                    description += child.text + " "
                tmp += 1
        
        tags = tmpTable[2]
        numRows = tmpTable[1]
        numCols = tmpTable[4]
        useLicense = "Refer to Source Webpage"
        title = title.text

        dataInfoObject = {
            "url": baseSite+link,
            "title": title,
            "tags": tags,
            "license": useLicense,
            "description": description,
            "infoKey1":  "Number of Rows",
            "infoValue1": numRows,
            "infoKey2": "Number of Columns",
            "infoValue2": numCols
        }
        datasetInfo.append(dataInfoObject)
    except:
        print(f'error -> count: {count}')
    count += 1


keys = datasetInfo[0].keys()
with open('ics_datasets.csv', 'w', encoding="utf-8", newline='') as output_file:
    dict_writer = csv.DictWriter(output_file, keys)
    dict_writer.writeheader()
    dict_writer.writerows(datasetInfo)