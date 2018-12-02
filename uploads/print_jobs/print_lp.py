import os
import sys
import mysql.connector
mydb = mysql.connector.connect(
	host="localhost",
  	user="root",
  	passwd=""
	)
mycursor = mydb.cursor()
mycursor.execute("USE printq")
done_jobs = open("done_jobs.txt",'r')
comp_jobs = []
for i in done_jobs:
	comp_jobs.append(i)
compjobs = []
co = 0
while co < len(comp_jobs):
	compjobs.append(comp_jobs[co].strip().split('.pdf')[0])
	co+=1
all_jobs = os.listdir()
alljobs = []
all_jobs.remove('completed_print_jobs')
all_jobs.remove('done_jobs.txt')
all_jobs.remove('print.sh')
for i in all_jobs:
	if ".pdf" not in i:
		all_jobs.remove(i)
k = 0
while k < len(all_jobs):
	alljobs.append(all_jobs[k].strip().split('.pdf')[0])
	k+=1
write_jobs = open("done_jobs.txt",'a')
pending_jobs = list(set(alljobs)-set(compjobs))
if len(pending_jobs) > 0:
	for i in pending_jobs:
		val = i.split('_')
		l_val = int(val[1])
		print('i is ',i)
		if l_val == 1:
			os.system("lp " + i + ".pdf")
		if l_val > 1:
			os.system("lp " + i + ".pdf -N " + l_val)
		write_jobs.write(i + '\n')
		sql="UPDATE printhistory SET printstatus = 1 WHERE id ="+val[0]
		mycursor.execute(sql)
		mydb.commit()
		name = i + ".pdf"
		os.rename(name, 'completed_print_jobs/' + name)