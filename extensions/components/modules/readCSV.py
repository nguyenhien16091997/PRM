import pandas as pd

def GetTableIntoArray(pathInput, pathOutput):
	# Get dataframe
	df = pd.read_csv(pathInput)
	
	#return 2-dimensional array
	return df

