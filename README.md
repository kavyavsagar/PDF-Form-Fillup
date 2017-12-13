# PDF-Form-Fillup
how to fill out PDF forms using PHP 


This module is used to fillout the fields inside a pdf with form(User) data using PHP. If any applications like bank, insurance or CV may fillout in HTML form and send to this module will generate PDF with posted data. This PDF can also be downloadable to our local machine. We need to follow few steps for that

1. Create a form fillable PDF file with field information (using adobe acrobat)

2. PDF template is not compatible with this script, so you should convert it into another format using <a href="https://www.pdflabs.com/tools/pdftk-server/">PDFtk</a> . Also run this command in CLI

pdftk termination-agreement.pdf output /uploads/fpdf/termination-agreement.pdf

What happends behind this script?
This script converted pdf formatted file into FDF format. FDF or Form Data File is a plain-text file, which can store form data in a much simpler structure than PDF files. We need to generate an FDF file  using PDFtk’s commands and merge user submitted data with original PDF file.

3. Extract all the field information from PDF and store it into another text file using this command.

pdftk /uploads/fpdf/termination-agreement.pdf dump_data_fields > /uploads/fpdf/termination-agreement.txt

4. Run this script with user data (Submitted form data) and it gets merged

5. After merging the user data with PDF form, the file get downloaded automatically.

Reference : http://www.fpdf.org/en/script/script93.php

OPTIONAL : Can flatten the output file to prevent future modifications. This is possible by passing flatten as a parameter to the fill_form command.

exec("pdftk path/to/form.pdf fill_form $FDFfile output path/to/output.pdf flatten"); 
