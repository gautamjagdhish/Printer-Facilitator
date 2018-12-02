#!/bin/bash
DIR="/mnt/c/xampp/htdocs/printq/uploads/print_jobs"
inotifywait -m -r -e create "$DIR" | while read f
do
    # you may want to release the monkey after the test :)
    sleep 3
    python3 print_lp.py
    # <whatever_command_or_script_you_liketorun>
done		