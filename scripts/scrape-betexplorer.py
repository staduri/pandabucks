# Scrapes odds data from http://www.betexplorer.com/soccer/world/

import sys
import csv
from bs4 import BeautifulSoup

writer = csv.writer(sys.stdout)
soup = BeautifulSoup(open(sys.argv[1]).read())
table = soup.find(class_='result-table')
group = ''

for row in table.find_all('tr'):
    if u'rtitle' in row['class']:
        # group (not used yet)
        group = row.find(class_='first-cell').text
    else:
        teams = row.td.a.text.replace(' ', '').split('-')
        scores = row.find(class_='result').text.split(':')
        odds = [tag['data-odd'] for tag in row.find_all(class_='odds')]
        writer.writerow(teams + scores + odds)
