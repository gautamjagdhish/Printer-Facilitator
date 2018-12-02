#!/bin/bash
DIR="/mnt/c/xampp/htdocs/printq/uploads"
inotifywait -m -r -e create "$DIR" | while read f
do
    # you may want to release the monkey after the test :)
    python3 slicer.py
    # <whatever_command_or_script_you_liketorun>
done