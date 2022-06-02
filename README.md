# Crowdsourcing Dataset Platform
### Team Name: Crowdsourcing Dataset Platform
### Team Members: Jacob Samar, Alan Hencey, David Gilson
### SEE FINALREPORT.PDF FOR FULL PROGRESS

## Introduction

The goal of this project is to create a web application that allows users to both access and create public datasets for use in their research or software development.  The motivation behind the project is to create a more central hub for users to find datasets and to also add to/create public datasets for overall public benefit.  Lots of datasets are spread around different sites and applications, and there might be different datasets that are either underdeveloped or non-existent that users can add to if given the ability.  In a way, the motivation is similar to how Wikipedia is thought of in that the public is able to create/modify datasets to benefit the overall public dataset domain for open source software or research use.

This project idea is semi-novel. Google has created a similar application at https://crowdsource.google.com/about/ but this website only allows users to contribute to Google’s proprietary datasets. Our project will allow any developer to request custom data or data-labeling services from the users who can all contribute to building open source datasets for use by anyone.

## Customer Value

The primary customer would be someone who requires specific datasets for their research or software project and needs an application that helps to centralize publicly available datasets.  As mentioned before, publicly available datasets can be spread across many sites and applications that a user doesn’t want to have to sift through to acquire specific datasets. The user might also have datasets they either have made from their own research or experiences that they’d like to make publicly available. Our project will provide a place for developers to come and find pre existing data sets that meet their needs as well as build completely new, customized datasets from scratch.

Currently, developers who need to create a new dataset must collect thousands of samples of data and then meticulously label and/or modify the data before it can be used to develop models. This can be done by a team of researchers or a group of paid volunteers, both of which require excessive time and money. The new capability provided by this project is a centralized platform where, given enough users, developers will be able to quickly and cost-effectively build datasets through collective contribution. We will be able to measure the success of the platform through how quickly developers are able to crowdsource the data they need for their datasets. If enough users are contributing to building datasets then developers should be able to reach their dataset goals in a relatively short period of time. If not, then some datasets may never be finished.

## Proposed Solution & Technology

![image](https://user-images.githubusercontent.com/73197003/154559887-93debdff-d197-453c-988e-27d49054df99.png)

This software will be web based, so users will be able to access it through a web browser. The website will be broken down into two main components. The first is a search engine that scours popular dataset websites as well as our own website for existing datasets, allowing users to see if a dataset already exists that matches their needs. The second is a crowdsourcing tool that allows developers to post requirements for a desired dataset as well as contribute to other datasets that have been posted. 

The architecture of our system has three main parts: a front-end, a scraping script, and a backend with a database. The front-end will be designed using the web framework bootstrap. It will enable the user to search all the publicly available datasets within our application, create a public request for a dataset, and contribute to public dataset requests submitted by users. A python scraping script will be created to scour the web for different public datasets that will be added to our database. Our backend database will be implemented with SQL and will store public dataset info and aggregate the datasets that can be created with our application. Public datasets will have descriptive info regarding the data and a link to the dataset on the web.  

The minimum viable product of our application would be the functionality of requesting specific datasets that can be crowdsourced by other users. This is the more novel and useful functionality of our proposed system. The aggregation of all publicly available datasets and the ability to effectively search them based on metadata, features, size, etc. would be very beneficial for our target audience. This search engine and dataset collection would allow machine learning engineers to quickly and conveniently find/create datasets for their projects. 

Our system will be tested throughout the development process with automated unit and integration tests to ensure functionality. For more comprehensive testing, hopefully we can create a minimal viable product in time to perform some informal user testing. From that user testing, we would hopefully get some insight into what features users like, any potential UI issues, and the overall usability of our system. 

## Team

Jacob Samar has built several similar components that will be needed to make this application work. This includes different web scraping applications for collecting data and several web based GUIs. Our web framework of choice is bootstrap, which is a framework Samar has never used before. However, web frameworks have similar programming concepts, so the previous projects written in react-native and ember.js give a base of experience. 

Alan Hencey has experience creating SQL databases and with Python web scraping.

David Gilson has created web-based GUIs with the tools (Bootstrap) that will be used in the project interface.  This tool is a library/template set for creating easy to use, adaptable GUIs with HTML/CSS/Javascript, and he has used it to create both desktop and mobile supported GUIs.

The roles of product manager and product owner will be randomly assigned each week. This will ensure that each member of the team will get some experience in each role throughout the project. 

## Project Management

Completion of the system is feasible.
We will meet twice weekly remotely or face-to-face if necessary.

Schedule:

- Sprint 1 - Ends February 18th
  - Complete project proposal
- Sprint 2 - Ends March 4th
  - Plan major future sprint milestones
  - Create first draft comprehensive design of platform functionality and integration.
  - Have barebones website page structure and navigation, SQL database table design, and beginnings of web crawler/search engine.
- Sprint 3 - Ends March 18th
  - TBD
- Sprint 4 - Ends April 1st
  - TBD
- Sprint 5 - Ends April 15th
  - TBD
- Sprint 6 - Ends April 29th
  - TBD
- Sprint 7 - Ends May 13th
  - TBD
- Sprint 8 - Ends May 27th
  - TBD

There are no regulatory or legal constraints, but one social concern is if malicious users submit bad data to others’ datasets. We will allow the creators/owners of a dataset to screen contributed data in order to filter out data that does not meet the criteria they required.
The data needed will all be open source data found through web scraping or data that has been contributed by users.
The minimum functionality that will need to be implemented for the project to be useful is the ability for developers to post requirements for datasets, and contribute to each others’ datasets. Without the search engine the platform can still operate and be useful, but possibly not as convenient.

## Development Process

We have chosen the Scrum framework as our development process. This is largely due to its flexibility of development, its structured tasks and roles, and that it is a process that each member of the team has some familiarity with. In addition, the three questions addressed each daily scrum  (‘What did you do yesterday?’, ‘What will you do today?’, ‘Are there any issues blocking you?’) are simple and efficient in enabling teamwork and communication.
XP explicitly engages with users as a main part of the process, which, without a dedicated user outside our group, makes it less worthwhile for this project. Waterfall seemed like a very rigid process, and didn't offer the flexibility of development that scrum offers. 

## Use Case
Here is a general use case of the platform as a whol:
- A researcher who is programming an AI photograph development tool would like some base picture data sets of common objects or perhaps even data already made by AI.  The researcher could go to the site, search for datasets with tags related to their needs, and train their AI photo generation tool.  After the researcher feels the tool does an adequate job and has produced photographic datasets based on their own tool, they could create or contribute back to any AI tagged photographic dataset on the site.  This method progressively builds onto and varies the datasets available on the site.

Here are some more use cases that are more specific/defined:
- Header buttons lead to the correct page when clicked
- User state is kept between page switches
- A user can type something into the search bar and a request to the database server is made
- The server can send back requested data and the results page can itemize that data
- A user can make a request to modify another user's data.  The requested user can view the request.

## Architectural Views
![image](https://user-images.githubusercontent.com/73197003/156689516-b4f9600e-31d6-4367-be32-e6100dd76ba4.png)

![image](https://user-images.githubusercontent.com/73197003/156689560-e50f0e98-8bbe-4f04-85b0-530acc4697df.png)

