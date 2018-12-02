import os
import PyPDF2
from PyPDF2 import PdfFileReader, PdfFileWriter, PdfFileMerger
import sys
from shutil import copyfile
def PDFsplit(pdf, splits, index, doc_name): 
    filenames = []
    pdfFileObj = open(pdf, 'rb') 
    pdfReader = PyPDF2.PdfFileReader(pdfFileObj) 
    if splits[0] > pdfReader.getNumPages() or splits[1] > pdfReader.getNumPages():
        print('error')
    else:
        start = splits[0] 
        end = splits[1] 
        pdfWriter = PyPDF2.PdfFileWriter() 
        outputpdf = pdf.split('.pdf')[0] + str(index) + '.pdf'
        for page in range(start,end): 
            pdfWriter.addPage(pdfReader.getPage(page)) 
        with open(outputpdf, "wb") as f: 
            pdfWriter.write(f) 
        pdfFileObj.close() 
        filenames.append(outputpdf)
        return filenames
def PDFMerge(lst,doc_name,doc_suff):
    merger = PdfFileMerger()
    for i in lst:
        merger.append(PdfFileReader(open(i[0],'rb')))
    merger.write(doc_name + '_' + doc_suff + ".pdf")
    file_name = doc_name + '_' + doc_suff + ".pdf"
    return file_name
a = os.listdir()
b = []
for i in a:
    if '_' in i and '.pdf' in i:
        b.append(i)
        print(i)
while len(b) > 0:
    in_progress_docs = []
    pdf = b[0]
    copyfile(b[0], 'all_jobs/' + b[0])
    c = pdf.split('_')
    d = c[1]
    suff = c[-2]
    e = d.split(',')
    values = []
    for i in e:
        if '-' in i:
            lr = i.split('-')
            values.append(int(lr[0]))
            values.append(int(lr[1]))
        else:
            values.append(int(i))
    m=max(values)
    print('m is ', m)
    pageobject = PyPDF2.PdfFileReader(pdf) 
    if m > pageobject.getNumPages():
        os.rename(b[0], 'incomplete_jobs/' + b[0])
        del(b[0])
        continue
    z = int(0)
    for f in e:
        if '-' in f:
            g = f.split('-')
            splits = [int(g[0])-1, int(g[1])]
        else:
            splits = [int(f)-1, int(f)]
        in_progress_docs.append(PDFsplit(pdf, splits, z, b[0]))
        z+=1
    print(in_progress_docs)
    print_job_name = PDFMerge(in_progress_docs,c[0],suff)
    while len(in_progress_docs) > 0:
        os.remove(in_progress_docs[0][0])
        del(in_progress_docs[0])
    print(print_job_name)
    os.rename(print_job_name, 'print_jobs/' + print_job_name)
    os.remove(b[0])
    del(b[0])