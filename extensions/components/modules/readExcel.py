import pandas as pd

def GetTableIntoArray(pathInput, pathOutput):
	# Get dataframe
	df = pd.read_excel(pathInput)
	
	#return 2-dimensional array
	return df

