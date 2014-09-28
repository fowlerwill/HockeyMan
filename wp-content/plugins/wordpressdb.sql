-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 21, 2013 at 02:02 AM
-- Server version: 5.5.24-log
-- PHP Version: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `wordpressdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `wp35_hockeymanarenas`
--

CREATE TABLE IF NOT EXISTS `wp35_hockeymanarenas` (
  `ID` varchar(4) DEFAULT NULL,
  `RINK` varchar(82) DEFAULT NULL,
  `ADDRESS` varchar(39) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `wp35_hockeymanarenas`
--

INSERT INTO `wp35_hockeymanarenas` (`ID`, `RINK`, `ADDRESS`) VALUES
('ACA', 'Acadia Recreation Centre (Calgary, AB)', '240 - 90th Ave. SE'),
('ADC', 'Adams Ice Centre (Lethbridge, AB)', '1302 9th Ave. N'),
('AGP', 'Argyll Plaza Arena (Edmonton, AB)', '6225 - 100 St. NW'),
('AGR', 'Agrena (Spruce Grove, AB)', '9 Agrena Rd.'),
('AKI', 'Akinsdale & Kinex Arenas (St. Albert, AB)', '66 Hebert Rd'),
('ALL', 'Alliance Arena (Alliance, AB)', 'Alliance, AB'),
('ALX', 'Alexandra Arena (Leduc, AB)', '47th Ave. & 49th St.'),
('AMA', 'Archie Miller Arena (Lloydminster, AB)', '4715 57 Ave.'),
('AND', 'Andrew Arena', 'Andrew, AB'),
('APL', 'Plainsmen Arena (Airdrie, AB)', '310 Centre Ave.'),
('ARA', 'A.G. Ross Arena (Elk Point, AB)', '5326 - 51 St.'),
('ARC', 'Akasaka Recreation Centre (Grande Cache, AB)', '10450 Hoppe Ave.'),
('ARD', 'Ardrossan Recreation Complex (Ardrossan, AB)', '80 - 1st Ave.'),
('ARM', 'Athabasca Regional Multiplex (Athabasca, AB)', '2 University Dr.'),
('ASM', 'Albert Stella Memorial Arena (Blairmore (Crowsnest Pass), AB)', '12602 - 17 Ave.'),
('AXA', 'Alix Arena (Alix, AB)', '5931 - 52 St.'),
('BAR', 'Barrhead Agrena (Barrhead, AB)', '5607 - 47th St.'),
('BAS', 'Bashaw Arena (Bashaw, AB)', '5020 52 St.'),
('BCA', 'Bassano & District Centennial Arena (Bassano, AB)', '249 - 6 Ave.'),
('BDA', 'Broadmoor Arena (Sherwood Park, AB)', '2100 Oak St.'),
('BEC', 'Baytex Energy Centre (Peace River, AB)', '9810 73 Ave'),
('BEI', 'Beiseker Arena (Beiseker, AB)', '5 St. & 4 Ave.'),
('BEN', 'Bentley Arena (Bentley, AB)', '5218 - 50th St.'),
('BHA', 'Bill Hunter Arena (formerly Jasper Place) (Edmonton, AB)', '9200 163rd St.'),
('BHR', 'Beacon Heights Community League Rink (Edmonton, AB)', '12037 - 43 St. NW'),
('BIA', 'Bow Island Arena (Bow Island, AB)', '240 - 4 Ave. E'),
('BKD', 'Blackfalds Arena (Blackfalds, AB)', '5302 Broadway Ave.'),
('BLA', 'Back Lakes Sports Arena (Red Earth Creek, AB)', '249 Red Earth Dr.'),
('BLC', 'Blackie Arena (Blackie, AB)', 'St. John St.'),
('BLD', 'Bold Centennial Arena (Lac La Biche, AB)', '8702 - 91 Ave.'),
('BLG', 'Beaverlodge Arena (Beaverlodge, AB)', '306 - 10A St.'),
('BNA', 'Barnett Arenas (Lacombe, AB)', '5210 - 54th Ave'),
('BON', 'Bon Accord Arena (Bon Accord, AB)', '4812 - 52nd St.'),
('BOR', 'Border Paving Camrose', '4512 - 53 St'),
('BOW', 'Bowness Sportsplex (Calgary, AB)', '7809 - 43 Ave. NW'),
('BOY', 'Millview Recreation Complex (Boyle, AB)', 'Boyle, AB'),
('BRC', 'Banff Recreation Centre (Banff, AB)', 'Mt. Norquay Rd.'),
('BRE', 'Brentwood Community Association Rink (Calgary, AB)', '1520 Northmount Dr.'),
('BRU', 'Bruderheim Hockey Arena (Bruderheim, AB)', '51 Ave. & 50 St.'),
('BSC', 'Bob Snodgrass Recreation Centre (High River, AB)', '228 - 12 Ave. SE'),
('BTA', 'Duncan Murray Recreation Centre (Hinton, AB)', '805 Switzer Dr.'),
('BVA', 'R.J. Lalonde Arena (Bonnyville, AB)', '4313 50 Ave.'),
('BVX', 'Big Valley Agriplex (Big Valley, AB)', '700 1 Ave. S'),
('CAC', 'Canadian Athletic Club Arena (Edmonton, AB)', '14640 142 St. NW'),
('CAL', 'Calahoo Arena (Calahoo, AB)', 'Range Rd. 275'),
('CAN', 'Coronation Arena (Coronation, AB)', 'Norfolk Ave. & King St.'),
('CAP', 'Cap Arena (St. Paul, AB)', '53rd St. & 48th Ave.'),
('CAS', 'Casman Centre (Formally Thickwood Arena)', '110 Eymundson Rd'),
('CCA', 'Cochrane Arena (Cochrane, AB)', '609 - 4th Ave.'),
('CCB', 'Flames Community Arenas (formerly Calgary Centennial Arenas) (Calgary, AB)', '2390 - 47 Ave. SW'),
('CCC', 'Crystal Centre (Grande Prairie, AB)', '10017 99 Ave.'),
('CCG', 'Calgary Centennial Arenas (Calgary, AB)', '2390 - 47 Ave. SW'),
('CCM', 'Charlie Cheeseman Memorial Ice Centre (Cardston, AB)', '343 Main St.'),
('CCN ', 'Coca-Cola Centre (Grande Prairie, AB)', '6 Knowledge Way'),
('CCS', 'Coca-Cola Centre (Grande Prairie, AB)', '6 Knowledge Way'),
('CDA', 'Castledowns Arena (Edmonton, AB)', '153 Ave. & 115 St.'),
('CDB', 'Castledowns Arena (Edmonton, AB)', '153 Ave. & 115 St.'),
('CDS', 'Coaldale Sportsplex (Coaldale, AB)', '1213 20 Ave.'),
('CEA', 'Centennial Arena (Lac La Biche, AB)', '101 Ave. & 99 St.'),
('CEN', 'Pason Centennial Arena (Okotoks, AB) ', '204 Community Way'),
('CET', 'Centennial Regional Arena (Brooks, AB)', '144071 Silver Sage Rd.'),
('CFA', 'Confederation Arena (Edmonton, AB)', '11204 43 Ave.'),
('CFT', 'Crowfoot Arena (Calgary, AB)', '8080 John Laurie Blvd. NW'),
('CGH', 'Centennial Arena (Stony Plain, AB)', '5300 52 St.'),
('CHA', 'Claresholm Arena (Claresholm, AB)', '50 Ave. & 2 St. E'),
('CHR', 'Chestermere Regional Community Association (Chestermere, AB) RED', '210 W. Chestermere Dr.'),
('CIC', 'Civic Ice Centre (Lethbridge, AB)', '6th Ave. & Stafford Dr. S'),
('CIV', 'Centennial Civic Centre Arena (Lloydminster, AB)', '5405 49 Ave.'),
('CKR', 'C.A. Knight Recreation Centre - MacDonald Island Arena (Fort McMurray, AB)', '151 MacDonald Dr.'),
('CLS', 'Cold Lake South Arena (Cold Lake (Grand Centre), AB) Clive Arena (Clive, AB)', '48 Ave. & 53 St. (Grande Centre)'),
('CLV', '', '5104 51 Ave.'),
('CMA', 'Chris McMillan Arena, Grande Prairie', '7407 108St Clairmont'),
('CMC', 'Carstairs Memorial Complex (Carstairs, AB)', '2100 Hwy-581'),
('CMM', 'Mark Messier Arena, St. Albert, AB', '400 Campbell Rd.'),
('COA', 'Coronation Arena (Edmonton, AB)', '13500 112 Ave.'),
('COL', 'Collicutt Centre Arena (Red Deer, AB)', '3031 30th Ave.'),
('CPE', 'Cardel Place (Calgary, AB)', '11950 Country Village Link NE'),
('CPW', 'Cardel Place (Calgary, AB)', '11950 Country Village Link NE'),
('CRA', 'Crestwood Arena (Edmonton, AB)', '9940 147 St.'),
('CRB', 'Crowchild Twin Arena Association (Calgary, AB)', '185 Scenic Acres Dr. NW'),
('CRC', 'Canmore Recreation Centre (Canmore, AB)', '1900 8th Ave.'),
('CRR', 'Crowchild Twin Arena Association (Calgary, AB)', '185 Scenic Acres Dr. NW'),
('CSA', 'Castor Arena (Castor, AB)', '5003 49th St.'),
('CSC', 'Crowsnest Sports Complex (Coleman (Crowsnest Pass), AB)', '8702 22 Ave.'),
('CSS', 'Consort Sportex (Consort, AB)', '4602 50 Ave.'),
('CTA', 'Centennial Arena (Three Hills, AB)', '202 3 Ave. N'),
('CTM', 'Troy Murray Arena, St. Albert, AB', '400 Campbell Rd.'),
('CVA ', 'Clareview Arena (Edmonton, AB)', '3804 139 Ave.'),
('CVB', 'Clareview Arena (Edmonton, AB)', '3804 139 Ave.'),
('CWA', 'Callingwood Recreation Centre (Edmonton, AB)', '17740 69th Ave.'),
('CWB ', 'Callingwood Recreation Centre (Edmonton, AB)', '17740 69th Ave.'),
('CWC', 'Common Wealth Centre (Lloydminster, AB)', '#1 5202 12 St.'),
('DAW', 'Memorial Arena (Dawson Creek, BC)', '1107 - 106th Ave.'),
('DBA', 'Dave Barr Arena (Grande Prairie, AB)', '9535 Prairie Rd.'),
('DCC', 'Dow Centennial Centre (Fort Saskatchewan, AB)', '8700 84 St.'),
('DDA', 'Didsbury Arena (Didsbury, AB)', '1702 21 Ave.'),
('DEV', 'Dale Fisher Arena (Devon, AB)', '32 Haven Ave.'),
('DKA', 'Dickson Arena (Spruceview, AB)', 'Spruceview, AB'),
('DLA', 'Delia Arena (Delia, AB)', '2nd Ave. N & 1st St. E'),
('DMA', 'Drumheller Memorial Arena (Drumheller, AB)', '20 1st Ave. W'),
('DOA', 'Donnan Arena (Edmonton, AB)', '9105 80 Ave.'),
('DPA', 'Derald Palmer Memorial Arena (Fox Creek, AB)', '1 St. & 2A Ave.'),
('DPX', 'Delburne Agriplex (Delburne, AB)', '2421 18 St.'),
('DQA', 'Leduc Recreation Centre (formerly Black Gold Centre) (Leduc, AB)', '4330 Black Gold Dr.'),
('DSC', 'Dave Shaw Memorial Complex (Hines Creek, AB)', '712 6 Ave.'),
('DUA', 'Duchess Arena (Duchess, AB)', '305 2nd St. W'),
('DVA', 'Drayton Valley Omniplex (Drayton Valley, AB)', '5737 45th Ave.'),
('DWC', 'Dawe Centre (Red Deer, AB)', '56 Holt St.'),
('ECA', 'Cold Lake Energy Centre (Cold Lake, AB)', '6 St. & Sammut Pl.'),
('ECB', 'East Calgary Twin Arena (Calgary, AB)', '299 Erin Woods Dr. SE'),
('ECR', 'East Calgary Twin Arena (Calgary, AB)', '299 Erin Woods Dr. SE'),
('EDG', 'Edge School (Calgary)', ''),
('EDW', 'Southland Leisure Centre - Ed Whalen & Justice Joseph Kryczka Arenas (Calgary, AB)', '2000 Southland Dr. SW'),
('EGA', 'Edgerton Skating Arena (Edgerton, AB)', '5120 52nd Ave.'),
('EIB', 'Edmonton IceBox (formerly Parkland Arena) (Edmonton, AB)', '10840 215 St. NW'),
('EKA', 'Eckville Arena (Eckville, AB)', '5312 51 St.'),
('ELC', 'Edson Leisure Centre (Edson, AB)', '1021 49 St.'),
('ELM', 'Elmwood Park Community Rink (Edmonton, AB)', '12505 75 St. NW'),
('ENC', 'Encana Centre  Camrose (formally Edgeworth Centre)', '5699 44 Ave.'),
('ERC', 'Enoch Recreation Centre (Enoch, AB)', 'Enoch Cree Nation - Hwy 60'),
('ESN', 'Ernie Starr Arena (Calgary, AB)', '4808 14 Ave. SE'),
('FAI', 'Fairview Community Association (Calgary, AB)', '8038 Fairmount Dr. SE'),
('FDB', 'Father David Bauer Arena (Calgary, AB)', '2424 University Dr. NW'),
('FGA', 'Forestburg Hockey Arena (Forestburg, AB)', '50 Ave. & 47 St.'),
('FHA', 'Falher Arena (Falher, AB)', '30 Central Ave. NW'),
('FLA', 'Frank Lacroix Arena (Fort McMurray, AB)', '155 Beaconwood Rd.'),
('FLC', 'Family Leisure Centre (Medicine Hat, AB)', '2000 Division Ave. NW'),
('FLC', 'Trico Centre (formerly Family Leisure Centre) (Calgary, AB)', '11150 Bonaventure Dr. SE'),
('FMC', 'Fort Macleod & District Recreation Centre (Fort Macleod, AB)', '235 21st St.'),
('FRA', 'Frank McCool Arena (Calgary, AB)', '1900 Lake Bonavista Dr. SE'),
('FSJ', 'North Peace Arena (Fort St. John, BC)', '96 Ave. & 96 St.'),
('FVA', 'Fort Vermilion Recreation Arena (Fort Vermilion, AB)', '5001 44 Ave.'),
('FVF', 'Fairview FairPlex (Fairview, AB)', '10317 109 St.'),
('GAC', 'Glen Allan Recreation Centre (Sherwood Park, AB)', '199 Georgian Way'),
('GEO', 'George Blundun Arena (Calgary, AB)', '5020 26 Ave. SW'),
('GFA', 'Grant Fuhr Arena Formally Agrena (Spruce Grove, AB)', '9 Agrena Rd.'),
('GHA', 'Glenn Hall Arena  Centennial Arena  Stony Plain', '5300 - 52 St.'),
('GIB', 'Gibbons Arena (Gibbons, AB)', '51 Ave. & 51 St.'),
('GLA', 'Glengarry Arena (Edmonton, AB)', '13340 85 St. NW'),
('GMA', 'Grimshaw Memorial Arena (Grimshaw, AB)', '50 St. & 49 Ave.'),
('GNA', 'Gleichen Arena (Gleichen, AB)', 'Gleichen, AB'),
('GTA', 'Grand Trunk Arena (Edmonton, AB)', '13025 112 St.'),
('HDM', 'Hythe & District Memorial Arena (Hythe, AB)', 'Hythe, AB'),
('HEN', 'Henderson Ice Centre (Lethbridge, AB)', '7 Ave. & Mayor Magrath Dr. S'),
('HHC', 'Hockey Hounds Recreation Centre (Medicine Hat, AB)', 'Division Ave. & 10 St. NE'),
('HLC', 'High Level Sports Complex (High Level, AB)', '105 Ave.'),
('HOL', 'Holmes Centre  Lloydminster', '#1 5202 12 St.'),
('HMA', 'Hardisty Memorial Arena (Hardisty, AB)', '48 Ave. & 49 St.'),
('HNA', 'Hanna Arena (Hanna, AB)', '501 3rd St. W'),
('HPP', 'High Prairie Sports Palace (High Prairie, AB)', '5409 49 St.'),
('HUN', 'Huntington Hills Community Association (Calgary, AB)', '520 78 Ave. NW'),
('HVA', 'Henry Viney Arena (Calgary, AB)', '814 13 Ave. NE'),
('IBH', 'Bill Herron Arena (Indus, AB)', 'Secondary Hwy-791 (North of Hwy-22X)'),
('IFA', 'Innisfail Arena (Innisfail, AB)', '5804 42 St.'),
('IIA', 'Igloo Ice Arena (Bowden, AB)', '2213 19 Ave.'),
('IMA', 'Irma Arena (Irma, AB)', '5108 53rd Ave.'),
('JAC', 'Jack Setters Arena (Calgary, AB)', '2020 69 Ave. SE'),
('JBA', 'Jubilee Arena (Westlock, AB)', '99 St. & 96 Ave.'),
('JCA', 'Jimmie Condon Arena (Calgary, AB)', '502 Heritage Dr. SW'),
('JJP', 'J.J. Parr Sports & Recreation Centre (Cold Lake (Medley), AB)', '4 Wing Cold Lake  Timberline & Kingsway'),
('JMA', 'Jaybird Memorial Arena (Calling Lake, AB)', 'Calling Lake, AB'),
('JOE', 'Southland Leisure Centre - Ed Whalen & Justice Joseph Kryczka Arenas (Calgary, AB)', '2000 Southland Dr. SW'),
('JOS', 'Moyer Recreation Complex (Josephburg, AB)', '54569 Range Road 215'),
('JPA', 'Jasper Arena (Jasper, AB)', 'Pyramid Ave. & Pyramid Lake Rd.'),
('JPC', 'J.J. Parr Sports & Recreation Centre (Cold Lake (Medley), AB)', 'Timberline & Kingsway'),
('JRC', 'Jubilee Recreation Centre (Fort Saskatchewan, AB)', '10013 96th Ave.'),
('KAX', 'Killam Agriplex (Killam, AB)', '5175 51st Ave. (Hwy-13)'),
('KBA', 'Kurt Browning Arena (Caroline, AB)', '5103 48 Ave.'),
('KCA', 'Knights of Columbus Sports Complex (Edmonton, AB)', '13160 137 Ave.'),
('KEA', 'Kenilworth Arena (Edmonton, AB)', '8313 68A St.'),
('KFA', 'Leduc Recreation Centre (formerly Black Gold Centre) (Leduc, AB)', '4330 Black Gold Dr.'),
('KIL', 'Kilkenny Community League (Edmonton, AB)', '14910 72 St.'),
('KIN', 'Kinsmen Rink (Dawson Creek', '1101 106th Ave.'),
('KMA', 'Kinsmen Twin Arenas (Edmonton, AB)', '1979 111 St. NW'),
('KMB', 'Kinsmen Twin Arenas (Edmonton, AB)', '1979 111 St. NW'),
('KN1', 'Kinsmen Twin Arenas (Red Deer, AB)', '5 McIntosh Ave.'),
('KNA', 'Kinsmen Arena (Peace River, AB)', '9810 73 Ave.'),
('KNC', 'Ken Nichol Regional Recreation Centre (Beaumont, AB)', '5303 - 50 St.'),
('KPX', 'Kinplex I & II (Medicine Hat, AB)', '2055 21 Ave. SE'),
('KTA', 'Kitscoty Arena (Kitscoty, AB)', '5018 51 St.'),
('KXA', 'Kinex Arena (Red Deer, AB)', '4309 48 Ave.'),
('LAK', 'Lake Bonavista Community Centre (Calgary, AB)', '1401 Acadia Dr.'),
('LAM', 'Lamont Arena (Lamont, AB)', '4844 48th Ave.'),
('LCC', 'Centennial Civic Centre Arena (Lloydminster, AB)', '5405 49 Ave.'),
('LEG', 'Legal Arena (Legal, AB)', '51st Ave. & 48th St.'),
('LEX', 'ENMAX Centre (Lethbridge, AB)', '2510 Scenic Dr. S'),
('LGC', 'La Glace Recreation Centre (La Glace, AB)', 'Hwy-724'),
('LIC', 'Labor Club Ice Centre (Lethbridge, AB)', '2020 18 Ave. N'),
('LLC', 'Lakeside Leisure Centre (Brooks, AB)', '111 4 Ave. W'),
('LOA', 'Londonderry Arena (Edmonton, AB)', '14520 66 St.'),
('MAA', 'Millet Agriplex Arena (Millet, AB)', '5290 45th Ave.'),
('MAX', 'Max Bell Centre (Calgary, AB)', '1001 Barlow Trail SE'),
('MB2', 'Max Bell Centre (Calgary, AB)', '1001 Barlow Trail SE'),
('MCA', 'Michael Cameron Arena (Edmonton, AB)', '10404 56 St.'),
('MCC', 'Memorial Community Centre Arena (Pincher Creek, AB)', '867 Main St.'),
('MCD', 'McLeod Community League (Edmonton, AB)', '14715 59 St. NW'),
('MCL', 'Whitecourt Twin Arenas (Whitecourt, AB)', '72 Sunset Blvd.'),
('MEM', 'Memorial B161 (Dawson Creek, BC)', '1107 106th Ave.'),
('MGA', 'Magrath Arena (Magrath, AB)', 'Magrath, AB'),
('MHA', 'Medicine Hat Arena (Medicine Hat, AB)', '155 Ash Ave. SE'),
('MKA', 'Mike Karbonik Arena (Calmar, AB)', '5019 47 St.'),
('MMA', 'Max McLean Arena (Camrose, AB)', '4512 - 53 St'),
('MMP', 'Medican Multi-plex (Sylvan Lake, AB)', '4823 48th St.'),
('MOA', 'Moose Recreation Centre (Medicine Hat, AB)', '6th St. & Division Ave. SW'),
('MOR', 'Morinville Arena (Morinville, AB)', '9908 104 St.'),
('MPA', 'Millennium Place North & South (Sherwood Park, AB)', '2000 Premier Way'),
('MPN', 'Millennium Place North & South (Sherwood Park, AB)', '2000 Premier Way'),
('MPS', 'Millennium Place North & South (Sherwood Park, AB)', '2000 Premier Way'),
('MRA', 'Marwayne Arena (Marwayne, AB)', 'S. 2 Ave.'),
('MRC', 'Mannville Recreation Centre (Mannville, AB)', '5202 52nd Ave.'),
('MRP', 'Marlborough Park Rink (Calgary, AB)', '6021 Madigan Dr. NE'),
('MSC', 'Manning Sports Centre Arena (Manning, AB)', '3 St. SE & 8 Ave. SE'),
('MUN', 'Mundare Arena', 'Mundare,AB'),
('MUR', 'Murray T. Copot Arena (Calgary, AB)', '6715 Centre St. N'),
('MWA', 'Mill Woods Arena (Edmonton, AB)', '7207 28 Ave.'),
('MWB', 'Mill Woods Arena (Edmonton, AB)', '7207 28 Ave.'),
('MYA', 'Mayerthorpe Arena (Mayerthorpe, AB)', '50 Ave. & 54 St.'),
('NCC', 'North County Recreation Complex (Picture Butte, AB)', '108 4th St. N'),
('NEE', 'Don Hartman North East Sportsplex (Calgary, AB)', '5206 68th St. NE'),
('NES', 'Don Hartman North East Sportsplex', '5206 - 68th Street N.E.'),
('NEW', 'Don Hartman North East Sportsplex (Calgary, AB)', '5206 68th St. NE'),
('NHA', 'Northstar Hyundia Arena (Formally Performance Arena) 400 Campbell Rd.', ''),
('NIC', 'Nicholas Sheran Ice Centre (Lethbridge, AB)', '401 Laval Blvd. W'),
('NLC', 'Northern Lights Recreation Centre (La Crete, AB)', '10201 99 Ave.'),
('NMP', 'Nampa arena (Nampa, AB', 'Nampa, AB'),
('NOR', 'Norma Bush Arena (Calgary, AB)', '2424 University Dr. NW'),
('NSA', 'New Sarepta Agriplex Arena (New Sarepta, AB)', '5088 1st Ave.'),
('NTA', 'NAIT Arena (Northern Alberta Institute of Technology) (Edmonton, AB)', '109 St. NW & Princess Elizabeth Ave. NW'),
('OAK', 'Oakridge Community Association (Calgary, AB)', '9504 Oakfield Dr. SW'),
('OLA', 'Oliver Arena (Edmonton, AB)', '10335 119 St.'),
('OMA', 'Oyen Memorial Arena (Oyen, AB)', 'Main St. & 6th Ave.'),
('ONO', 'Onoway Arena (Onoway, AB)', '5004 53 Ave.'),
('OPT', 'Optimist Arena (Calgary, AB)', '5020 26 Ave. SW'),
('ORA', 'Oilfields Regional Arena (Black Diamond, AB)', '611 3 St. SW'),
('ORC', 'Okotoks Recreation Centre (Okotoks, AB)', '99 Okotoks Dr.'),
('OSC', 'Olds & District Sports Complex (Olds, AB)', '5133 52nd St.'),
('PCC', 'Ponoka Culture & Recreation Complex (Ponoka, AB)', '4310 54 St.'),
('PEN', 'Pengrowth Saddledome (Calgary, AB)', 'Olympic Way'),
('PEP', 'Stu Peppard Arena (Calgary, AB)', '5300 19 St. SW'),
('PKA', 'Pete Knight Arena (Crossfield, AB)', '920 Mountain Ave.'),
('PLP', 'Polar Palace (Valleyview, AB)', '4429 52 Ave.'),
('PMA', 'Plamondon Arena (Plamondon (Wandering River), AB)', '97 Ave.'),
('PMM', 'Peace Memorial Multiplex (Wainwright, AB)', '605 2nd Ave.'),
('PMX', 'Penhold Multi-plex', '1 Waskasoo Avenue (Rge Rd 280)'),
('PRA', 'Peace River Arena', ''),
('PRP', 'Pembina Rec Plex (Evansburg, AB)', '4712 52 Ave.'),
('PVA', 'Provost Arena (Provost, AB)', '5016 46 St.'),
('PWP', 'Prairie Winds Park Rink (Calgary, AB)', '223 Castleridge Blvd. NE'),
('RAC', 'Rocky Arena Complex (Rocky Mountain House, AB)', '5332 50 St.'),
('RBA', 'Russ Barnes Arena (formerly Santa Rosa Arena) (Edmonton, AB)', '6725 121 Ave.'),
('RCA', 'Redcliff Arena (Redcliff, AB)', '131 1st St. SW'),
('RCL', 'Rosslyn Community League (Edmonton, AB)', '11015 134 Ave. NW'),
('RDA', 'Red Deer Arena (Red Deer, AB)', '4725 43rd St.'),
('REC', 'Edgeworth Centre (Camrose, AB)', '4512 - 53 St'),
('RED', 'Provident Place (formerly Redwater Multiplex) (Redwater, AB)', '4944 53rd St.'),
('REX', 'ENMAX Centrium (Westerner Park) (Red Deer, AB)', '4847A 19 St.'),
('RIA', 'Raymond Ice Arena (Raymond, AB)', '1st Ave. N & Broadway'),
('RIV', 'River Cree Twin Rinks (Enoch, AB)', 'Whitemud Dr. & Winterburn Rd'),
('RLA', 'Rainbow Lake Arena (Multi-Use Facility) (Rainbow Lake, AB)', '1 Atco Rd.'),
('RMA', 'Rimbey Arena (Rimbey, AB)', '5109 54th St.'),
('ROS', 'Rose Kohn Arena (Calgary, AB)', '502 Heritage Dr. SW'),
('RPA', 'Rexall Place (formerly Northlands Coliseum) (Edmonton, AB)', '119 Ave. NW & Wayne Gretzky Dr.'),
('RQB', 'Riviere Qui Barre Arena (Riviere Qui Barre, AB)', 'Riviere Qui Barre, AB'),
('RRA', 'Russ Robertson Arena (Lloydminster, AB)', '5105 34 St.'),
('RRC', 'Rosemary Recreation Complex (Rosemary, AB)', '101 Centre St.'),
('RUS', 'Servus Sports Centre (formerly Common Wealth Centre) Lloydminster', '#1 5202 12 St.'),
('RWA', 'Common Wealth Centre (Lloydminster, AB)', '#1 5202 12 St.'),
('RYA', 'Ridgevalley Arena (Ridgevalley, AB)', 'Ridgevalley Rd.'),
('RYS', 'Rockyford Sportsplex (Rockyford, AB)', '1st St. East & 1st Ave.'),
('SAA', 'Sangudo & District Agricultural Society Arena (Sangudo, AB) Sangudo, AB', ''),
('SAR', 'Sarcee Seven Chiefs Sportsplex (Calgary, AB)', '3700 Anderson Rd. SW'),
('SBA', 'Leduc Recreation Centre (formerly Black Gold Centre) (Leduc, AB)', '4330 Black Gold Dr.'),
('SCA', 'Stampede Corral Arena (Calgary, AB)', '555 Saddledome Rise SE'),
('SCC', 'SAIT Campus Centre (Calgary, AB)', '1301 16 Ave. NW'),
('SCR', 'RUSWAY - Servus Sports Centre (formerly Common Wealth Centre) Lloydminster', '#1 5202 12 St.'),
('SCH', 'HOLMES - Servus Sports Centre (formerly Common Wealth Centre) Lloydminster', '#1 5202 12 St.'),
('SDA', 'Standard Arena (Standard, AB)', '902 The Broadway'),
('SFC', 'South Fish Creek Twin Arenas (Calgary, AB)', '100, 333 Shawville Blvd. SE'),
('SHA', 'Duncan Murray Recreation Centre (Hinton, AB)', '805 Switzer Dr.'),
('SHO', 'Shouldice Arena (Calgary, AB)', '1515 Home Rd. NW'),
('SKC', 'Sedgewick Recreation Centre (Sedgewick, AB)', '5301 51 Ave.'),
('SLA', 'Arctic Ice Centre (Slave Lake, AB)', '305 - 6 Ave. SW'),
('SLC', 'Strathmore Family Centre (Strathmore, AB)', '160 Brent Blvd.'),
('SLC', 'Southland Leisure Centre - Ed Whalen & Justice Joseph Kryczka Arenas (Calgary, AB)', '2000 Southland Dr. SW'),
('SMA', 'Smoky Lake Arena (Smoky Lake, AB)', '4612 54 Ave.'),
('SOB', 'Sobey''s Arena Leduc Recreation Centre', '4330 Black Gold Dr.'),
('SOC', 'Strathcona Olympiette Centre & Fultonvale Arena (Ardrossan (Fultonvale), AB)', '52029 Range Road 224'),
('SPA', 'Sherwood Park Arena Sports Centre & Shell (Sherwood Park, AB)', '2015 Oak St.'),
('SPJ', 'Springbank Park For All Seasons (Calgary, AB)', '32224 Springbank Rd.'),
('SPL', 'Spray Lake Sawmills Family Sports Centre (Cochrane, AB)', '800 Griffin Rd. E'),
('SPR', 'Springbank Park For All Seasons (Calgary, AB)', '32224 Springbank Rd.'),
('SPS', 'Sherwood Park Arena Sports Centre & Shell (Sherwood Park, AB)', '2015 Oak St.'),
('SPX', 'Fort Saskatchewan Sportsplex Arena (Fort Saskatchewan, AB)', '9513 89th St.'),
('SRA', 'Spirit River Ag-rena (Spirit River, AB)', '44th Ave.'),
('SRC', 'Stettler Recreation Centre (Stettler, AB)', '6202 44 Ave.'),
('SSA', 'George S. Hughes South Side Arena (Edmonton, AB)', '10525 72 Ave. NW'),
('SSC', 'Whitecourt Twin Arenas (Whitecourt, AB)', '72 Sunset Blvd.'),
('SSR', 'Scott Seaman Rink (Dewinton, AB)', '32156 Hwy 552 East'),
('STA', 'Stu Barnes Arena Formally Agrena - (Spruce Grove, AB)', '9 Agrena Rd.'),
('STP', 'Clancy Richard Arena (St. Paul, AB)', '5314 48th Ave.'),
('STU', 'Stu Peppard Arena (Calgary, AB)', '5300 19 St. SW'),
('STV', 'Stavely Arena (Stavely, AB)', '53 Ave. & Young Cres.'),
('STW', 'Stew Hendry & Henry Viney Arenas (Calgary, AB)', '814 13 Ave. NE (Renfrew Athletic Park)'),
('SUA', 'Sundre Arena (Sundre, AB)', '101 2 Ave. NW'),
('SWA', 'Swan Hills Arena (Swan Hills, AB)', '5632 Main St.'),
('SXA', 'Sexsmith Arena (Sexsmith, AB)', '9800 93 St.'),
('TAB', 'Taber Community Centre (Taber, AB)', '50 St. & 48 Ave.'),
('TDA', 'Thickwood Arena (Fort McMurray, AB)', '110 Eymundson Rd'),
('THA', 'Thorhild Agriplex (Thorhild, AB)', '15 7th Ave.'),
('THC', 'Tom Hornecker Recreation Centre (Nanton, AB)', '2122 18 St.'),
('THO', 'Thorncliffe Greenview Community Association (Forbes Innis Arena) (Calgary, AB)', '5600 Centre St. NW'),
('TIA', 'Tipton Arena (Edmonton, AB)', '10828 80 Ave.'),
('TLN', 'TransAltaTri-Leisure Centre (Spruce Grove, AB)', '221 Campsite Rd.'),
('TLS', 'TransAltaTri-Leisure Centre (Spruce Grove, AB)', '221 Campsite Rd.'),
('TOF', 'Tofield Arena (Tofield, AB)', '48th St.'),
('TOT', 'Totem Centre  Cochrance', 'Cochrane, AB'),
('TRA', 'Trochu Arena (Trochu, AB)', 'Trochu, AB'),
('TRB', 'Thorsby Recreation Complex (Thorsby, AB)', '4901 48 Ave.'),
('TRI', 'Triwood Community Association Rink (Calgary, AB)', '2244 Chicoutimi Dr. NW'),
('TWA', 'Terwilliger Arenas 4 Plex (Edmonton S.E.) A,B,C,D', '23 ave (Terwilliger)'),
('TWB', 'Airdrie & District Regional Recreation Complex (Twin Arena) (Airdrie, AB)', '200 East Lake Cres.'),
('TYA', 'Tilley Arena (Tilley, AB)', 'Tilley, AB'),
('UAB', 'Clare Drake Arena (Edmonton, AB)', '87 Ave. NW (& 115 St.)'),
('VAA', 'Vilna Agri-Plex Arena (Vilna, AB)', '50th St. & 53rd Ave.'),
('VDA', 'Vern Davis Arena  Formally Callingwood A  Edmonton', '17740 69th Ave.'),
('VEG', 'Vegreville Recreation Centre Arena (Vegreville, AB)', '4509 48th St.'),
('VIK', 'Viking Carena Complex (Viking, AB)', '5120 45 St.'),
('VIP', 'Vulcan Iceplex (Vulcan, AB)', '705 Elizabeth St.'),
('VRC', 'Vauxhall Recreation Centre (Vauxhall, AB)', '417 4th St. N'),
('VS1', 'Village Square Leisure Centre (Calgary, AB)', '2623 56 St. NE'),
('VS2', 'Village Square Leisure Centre (Calgary, AB)', '2623 56 St. NE'),
('VSA', 'Vermilion Stadium/Arena (Vermilion, AB)', '47 Ave. & 55 St.'),
('WAB', 'Wabamun Arena (Wabamun, AB)', '4820 52 Ave.'),
('WBA', 'Wabasca Arena (Wabasca, AB)', 'Wabasca, AB'),
('WCC', 'Wetaskiwin Civic Centre Twin Arenas (Wetaskiwin, AB)', '4519 50th Ave.'),
('WDA', 'Winfield Arena (Winfield, AB)', 'Winfield, AB'),
('WES', 'Westside Regional Recreation Centre (Calgary, AB)', '2000 69 St. SW'),
('WGA', 'Warburg Arena (Warburg, AB)', '5339 50A Ave.'),
('WHT', 'West Hillhurst Community Centre (Calgary, AB)', '1940 6 Ave. NW'),
('WMP', 'West Mount Pleasant Community Sportsplex (Calgary, AB)', '610 23 Ave. NW'),
('WPC', 'Wanham COCO Sports Complex (Wanham, AB)', 'Wanham, AB'),
('WSA', 'West Smoky Arena (Eaglesham, AB)', 'Eaglesham, AB'),
('WSC', 'Winsports Canada  (Canada Olympic Park)', '88 Canada Olympic Road SW'),
('WWA', 'Westwood Arena (Edmonton, AB)', '12040 97 St.'),
('YTA', 'Youngstown Arena (Youngstown, AB)', '411 Main St.'),
('', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `wp35_hockeymanattendance`
--

CREATE TABLE IF NOT EXISTS `wp35_hockeymanattendance` (
  `playerid` int(11) NOT NULL,
  `gameid` int(11) NOT NULL,
  `1n0ut` int(11) NOT NULL,
  PRIMARY KEY (`playerid`,`gameid`),
  KEY `gameid` (`gameid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wp35_hockeymanattendance`
--

INSERT INTO `wp35_hockeymanattendance` (`playerid`, `gameid`, `1n0ut`) VALUES
(1, 1384325101, 0),
(1, 1388923201, 0),
(1, 1388982601, 0);

-- --------------------------------------------------------

--
-- Table structure for table `wp35_hockeymangames`
--

CREATE TABLE IF NOT EXISTS `wp35_hockeymangames` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `datetime` datetime NOT NULL,
  `desc` varchar(20) NOT NULL,
  `loc` varchar(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1388982602 ;

--
-- Dumping data for table `wp35_hockeymangames`
--

INSERT INTO `wp35_hockeymangames` (`id`, `userid`, `datetime`, `desc`, `loc`) VALUES
(1, 1, '2013-11-04 09:00:00', 'the Game', 'lol'),
(24, 1, '2013-11-01 01:00:00', 'Description', 'Loc'),
(25, 1, '2013-12-19 06:45:00', 'sugamaother', 'meo'),
(78, 0, '2013-11-20 09:30:00', 'md52', 'Loc'),
(1384325101, 1, '2013-11-13 06:45:00', 'UTC', 'Loc'),
(1385801101, 1, '2013-11-16 08:45:00', 'vs George', 'loc'),
(1387517401, 1, '2013-11-20 05:30:00', 'New Shit2', 'plo'),
(1387517402, 1, '2013-11-23 01:00:00', 'Description', 'meo'),
(1387517403, 1, '2014-01-03 08:45:00', 'try attendance', 'Loc'),
(1387517404, 1, '2013-11-30 09:00:00', 'Description', 'Loc'),
(1387517405, 1, '2014-01-04 05:30:00', 'Description', 'Loc'),
(1387517406, 1, '2014-01-05 03:00:00', 'Description', 'Loc'),
(1387517407, 1, '2014-01-05 10:30:00', 'Description', 'Loc'),
(1387517408, 1, '2014-01-05 04:00:00', 'Description', 'Loc'),
(1388923201, 1, '2014-01-05 12:00:00', 'Description', 'Loc'),
(1388982601, 1, '2014-01-07 12:00:00', 'latest', 'the');

-- --------------------------------------------------------

--
-- Table structure for table `wp35_hockeymanplayers`
--

CREATE TABLE IF NOT EXISTS `wp35_hockeymanplayers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fname` varchar(20) NOT NULL,
  `lname` varchar(20) NOT NULL,
  `phone` varchar(14) NOT NULL,
  `email` varchar(20) NOT NULL,
  `address` varchar(200) NOT NULL,
  `position` varchar(20) NOT NULL,
  `teamid` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userid` (`teamid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `wp35_hockeymanplayers`
--

INSERT INTO `wp35_hockeymanplayers` (`id`, `fname`, `lname`, `phone`, `email`, `address`, `position`, `teamid`) VALUES
(1, 'Will', 'Fowler', '4036017855', 'will@incitepromo.com', '523 Sabrina Rd SW Calgary, AB T2W 1Y7', 'Right Wing', 1);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `wp35_hockeymanattendance`
--
ALTER TABLE `wp35_hockeymanattendance`
  ADD CONSTRAINT `wp35_hockeymanattendance_ibfk_5` FOREIGN KEY (`gameid`) REFERENCES `wp35_hockeymangames` (`id`),
  ADD CONSTRAINT `wp35_hockeymanattendance_ibfk_1` FOREIGN KEY (`playerid`) REFERENCES `wp35_hockeymanplayers` (`id`),
  ADD CONSTRAINT `wp35_hockeymanattendance_ibfk_2` FOREIGN KEY (`playerid`) REFERENCES `wp35_hockeymanplayers` (`id`),
  ADD CONSTRAINT `wp35_hockeymanattendance_ibfk_3` FOREIGN KEY (`gameid`) REFERENCES `wp35_hockeymangames` (`id`),
  ADD CONSTRAINT `wp35_hockeymanattendance_ibfk_4` FOREIGN KEY (`playerid`) REFERENCES `wp35_hockeymanplayers` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
