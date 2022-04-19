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
                        password='darkpie')#give ur username, password
    if conn.is_connected():
        cursor = conn.cursor()
        # cursor.execute("CREATE DATABASE employee")
        print("Database is connected to")
except Error as e:
    print("Error while connecting to MySQL", e)



icsData = pd.read_csv('ics_datasets.csv', converters={'title': lambda x: x[:100],
 'description': lambda x: x[:5000]})
icsData['web_source'] = 'ICS'

kaggleData = pd.read_csv('kaggle_datasets.csv', converters={'title': lambda x: x[:100],
 'description': lambda x: x[:5000]})
kaggleData['web_source'] = 'Kaggle'

# ['url',
#  'title',
#  'description']


#  'keywords', --> tags
#  'usabilityRating', > to 'infoKey1'
#  'totalDownloads',> to 'infoKey2'
kaggleData.rename(columns={'keywords': 'tags', 'usabilityRating': 'infoKey1', 'totalDownloads': 'infoKey2', 'license': 'licenses'}, inplace=True)

# value of goes to 'infoValue1'
kaggleData['infoValue1'] = kaggleData['infoKey1']
kaggleData['infoKey1'] = kaggleData['infoKey1'].apply(lambda x: 'Usability Rating')

# value to 'infoValue2'
kaggleData['infoValue2'] = kaggleData['infoKey2']
kaggleData['infoKey2'] = kaggleData['infoKey2'].apply(lambda x: 'Number of Downloads')

#  'license', > to 'licences'  comma seperated list of them
kaggleData['licenses'] = kaggleData['licenses'].apply(lambda x: x.replace('[', '').replace(']', '').replace('"', '').replace("'", ""))
kaggleData['tags'] = kaggleData['tags'].apply(lambda x: x.replace('[', '').replace(']', '').replace('"', '').replace("'", ""))

#  'totalViews', --> drop col
#  'totalVotes', --> drop col
kaggleData.drop('totalViews', inplace=True, axis=1)
kaggleData.drop('totalVotes', inplace=True, axis=1)


# ICS
    # ['url',
    # 'title',
    #  'tags',
    #  'license',
    #  'description',
    #  'infoKey1',
    #  'infoValue1',
    #  'infoKey2',
    #  'infoValue2']

icsData.rename(columns={'license': 'licenses'}, inplace=True)

kaggleData.fillna("", inplace=True)
icsData.fillna("", inplace=True)

# kaggleData.to_csv('dbReadyKaggle.csv', encoding='utf-8')
# icsData.to_csv('dbReadyICS.csv', encoding='utf-8')

for i,row in icsData.iterrows():
            #here %S means string values
            sql = "INSERT INTO crowdsource_website_db.externalDatasets (url, title, tags, licenses, description, infoKey1, infoValue1, infoKey2, infoValue2, web_source) VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)"
            cursor.execute(sql, tuple(row.values))
            print("Record inserted")
            # the connection is not auto committed by default, so we must commit to save our changes
            conn.commit()

for i,row in kaggleData.iterrows():
            #here %S means string values
            sql = "INSERT INTO crowdsource_website_db.externalDatasets (url, title, tags, licenses, infoKey1, infoKey2, description, web_source, infoValue1, infoValue2) VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)"
            cursor.execute(sql, tuple(row.values))
            print("Record inserted")
            # the connection is not auto committed by default, so we must commit to save our changes
            conn.commit()
