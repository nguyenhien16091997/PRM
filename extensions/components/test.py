import xlsxwriter

# Create a workbook and add a worksheet.
workbook = xlsxwriter.Workbook('C:/Users/COMPUTER/Downloads/Expenses01.xlsx')
worksheet = workbook.add_worksheet()

workbook.close()