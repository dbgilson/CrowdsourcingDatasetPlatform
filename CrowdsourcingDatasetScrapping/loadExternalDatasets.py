# Code for cleaning up scraping data and inserting it into the mysql db 

import pandas as pd
import mysql.connector as msql
from mysql.connector import Error

# Format of the schema in the db
    # title VARCHAR(100) NOT NULL,
    # description VARCHAR(5000) NOT NULL,
    # tags VARCHAR(500) NOT NULL,     -- ',' seperated string of tags
    # url VARCHAR(150) NOT NULL,
    # web_source VARCHAR(30) NOT NULL, -- "Kaggle, ICS, Our Site"
    # licenses VARCHAR(100) NOT NULL, --  comma string of each license
    # infoKey1 VARCHAR(30), -- kaggle = usability rating  ics = number of rows
    # infoValue1 FLOAT(10),       --
    # infoKey2 VARCHAR(30), -- kaggle = number of downloads  ics = number of columns
    # infoValue2 INT(15)

try:
    conn = msql.connect(host='localhost', user='root',
                        password='')#give ur username, password
    if conn.is_connected():
        cursor = conn.cursor()
        # cursor.execute("CREATE DATABASE employee")
        print("Database is connected to")
except Error as e:
    print("Error while connecting to MySQL", e)

icsData2 = pd.read_csv('dbReadyICS.csv', converters={'title': lambda x: x[:100],
 'description': lambda x: x[:5000]})

kaggleData2 = pd.read_csv('dbReadyKaggle.csv', converters={'title': lambda x: x[:100],
 'description': lambda x: x[:5000]})

print(icsData2.columns)
icsData2.drop('Unnamed: 0', inplace=True, axis=1)
kaggleData2.drop('Unnamed: 0', inplace=True, axis=1)
kaggleData2.fillna("", inplace=True)
icsData2.fillna("", inplace=True)

for i,row in icsData2.iterrows():
            #here %S means string values
            sql = "INSERT INTO crowdsource_website_db.externalDatasets (url, title, tags, licenses, description, infoKey1, infoValue1, infoKey2, infoValue2, web_source) VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)"
            cursor.execute(sql, tuple(row.values))
            print("Record inserted")
            # the connection is not auto committed by default, so we must commit to save our changes
            conn.commit()

for i,row in kaggleData2.iterrows():
            #here %S means string values
            sql = "INSERT INTO crowdsource_website_db.externalDatasets (url, title, tags, licenses, infoKey1, infoKey2, description, web_source, infoValue1, infoValue2) VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)"
            cursor.execute(sql, tuple(row.values))
            print("Record inserted")
            # the connection is not auto committed by default, so we must commit to save our changes
            conn.commit()
