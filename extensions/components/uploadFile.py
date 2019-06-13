import numpy 
import pandas 
import argparse
import math as m
import xlsxwriter
	
def parsers_in():
	parser = argparse.ArgumentParser(description='Compress a file using various algorithms')

	# Add positional and optional arguments
	parser.add_argument('input_file', help='file to be compressed')
	parser.add_argument('output_file', help='compressed output file')
	parser.add_argument('--alg', help='algorithm will be used')

	# Parse argument
	return parser.parse_args()

def arrayData():
	#
	args = parsers_in()
	
	#get typeFile
	typeFile= (((args.input_file).split("\\")[-1]).split('.'))[-1]

	#get array type numpy
	if typeFile == 'csv':
		array= pandas.read_csv(args.input_file)
	elif typeFile == 'xlsx' or typeFile == 'xls' or typeFile == 'xlsm':
		array = pandas.read_excel(args.input_file)	
	else:
		array=''
	return array

def EncryptionArray(array):
	d = 1
	for i in range(0, numpy.size(array[0], axis=0)):
		for j in numpy.unique(array[:,i]):
			for k in numpy.where(array[:,i] == j)[0]:
				array[k][i] = d
			d = d + 1		
	return array

def CaculateGain(WP, WN ,_WP, _WN):	
	gain = _WP*(m.log(_WP/(_WP+(_WP+_WN)))-m.log(WP/(WP+(WP+WN))))
	return gain

def CaculateA(ATT, PN, WP, WN):
	A = numpy.array([[0,0]])
	for i in range(0, numpy.size(ATT)):
			
		#handle caculate
		_WP = PN[i][0]				
		_WN = PN[i][1]

		if _WP == 0:
			gain = 0
		else:
			gain = CaculateGain(WP, WN, _WP, _WN)

		#add result into A					
		A = numpy.append(A, [[0, gain]], axis=0)
	A = numpy.delete(A, 0, axis=0)		
	return A

def ReduceWeightP(P,item):	
	for i in range(0, numpy.size(P, axis=0)):	
		if numpy.in1d(item, P[i])[0] == True :
			# P[i][-1] = P[i][-1].astype(numpy.float)*(1/3)
			P[i][-1] = P[i][-1]*(1/3)
	return P

def ReduceWeightN(N,item):	
	for i in range(0, numpy.size(N, axis=0)):	
		if numpy.in1d(item, N[i])[0] == True :
			# N[i][-1] = N[i][-1].astype(numpy.float)*(1/3)
			N[i][-1] = N[i][-1]*(1/3)
	return N

def GenneratePN(ATT, P, N):	
	PN = numpy.array([[0, 0]])	
	for att in ATT:
		p_location = numpy.where(P[:,0:-1] == att)
		n_location = numpy.where(N[:,0:-1] == att)
		wp = 0
		wn = 0
		for i in p_location[0] :
			# wp = wp + P[:,-1][i].astype(numpy.float)
			wp = wp + P[:,-1][i]

		for j in n_location[0] :
			# wn = wn + N[:,-1][j].astype(numpy.float)
			wn = wn + N[:,-1][j]
		
		PN = numpy.append(PN, [[wp, wn]], axis=0)			
	PN = numpy.delete(PN, (0), axis=0)
	return PN

def RemoveRecords_P(_P, i):
	p_location = numpy.where(_P[:,0:-1]==i)
	_P_out = numpy.array([_P[0]])

	for j in p_location[0]:
		_P_out = numpy.append(_P_out, [_P[j]], axis=0)

	return numpy.delete(_P_out, 0, axis=0)

def RemoveRecords_N(_N, i):
	n_location = numpy.where(_N[:,0:-1]==i)
	_N_out = numpy.array([_N[0]])

	for j in n_location[0]:
		_N_out = numpy.append(_N_out, [_N[j]], axis=0)

	return numpy.delete(_N_out, 0, axis=0)

def CaculateLapace(n_c, n_total, k):
	return ((n_c+1)/(n_total+k))*100
def specifyPN():
	#init
	L = numpy.array([[0,0,0]])
	R = numpy.array([[0,0,0,0]])
	MIN_BEST_GAIN = 0.7	

	df = arrayData()
	
	array= df.values

	array_core= EncryptionArray(array.copy())
	
	#Attribute
	ATT  = numpy.unique(numpy.delete(array_core, -1, axis=1))

	C = numpy.unique(array_core[:,-1])

	#count C
	k = numpy.size(C)

	#generate an empty global attributes array A
	A = numpy.array([[0, 0]])

	for c in C:		
		# postitives
		P = array_core[numpy.where(array_core[:,-1]==c)]		
		
		# negatives
		N = array_core[numpy.where(array_core[:,-1]!=c)]
		
		#size
		size_ar_core = numpy.size(array_core,0) #15
		size_P		 = numpy.size(P,0) #6
		size_N		 = numpy.size(N,0)#9

		#set total weight P & N
		P = numpy.c_[P, numpy.ones(size_P)]	
		N = numpy.c_[N, numpy.ones(size_N)]		
		# WP		     = numpy.sum(P[:,-1].astype(numpy.float))		
		# WN		     = numpy.sum(N[:,-1].astype(numpy.float))
		WP		     = numpy.sum(P[:,-1])		
		WN		     = numpy.sum(N[:,-1])

		#Total Weight Threshold (TWT)	
		TOTAL_WEIGHT_FACTOR = 0.05
		TWT = WP*TOTAL_WEIGHT_FACTOR

		#PN array
		PN = GenneratePN(ATT, P, N)

		A = CaculateA(ATT, PN, WP, WN)
	
		while WP > TWT:			
 			#copy  P, N, A and PN: P', N', A' and PN'
			_P = P
			_N = N
			_A = A
			_PN = PN

			r = numpy.array([[0, 0]])
			
			_NSizePre = 0
			while True:		

				#get location best gain
				best_gain = numpy.where(_A[:,-1] == numpy.amax(_A[:,-1]))

				#COMPARE MINGAIN
				if(_A[best_gain[0][0]][1] <= MIN_BEST_GAIN):
					break
				
				r = numpy.append(r, [[ATT[best_gain[0][0]], c]], axis=0)
				
				#Adjust PN
				_P = RemoveRecords_P(_P, ATT[best_gain[0][0]])
				_N = RemoveRecords_N(_N, ATT[best_gain[0][0]])	
				_PN = GenneratePN(ATT, _P, _N)

				if (_N.size == 0) :
					break

				# _WP = numpy.sum(_P[:,-1].astype(numpy.float))
				# _WN = numpy.sum(_N[:,-1].astype(numpy.float))
				_WP = numpy.sum(_P[:,-1])
				_WN = numpy.sum(_N[:,-1])
				
				_A = CaculateA(ATT, _PN, _WP, _WN)			
			
			r = numpy.delete(r, 0, axis=0)

			if numpy.size(r) == 0:
				break

			#reduce weighting by decay factor and adjust PN array accordingly
			for i in r:
				P  = ReduceWeightP(P, i[0])
				# N  = ReduceWeightN(N, i[0])
				n_total = numpy.count_nonzero(array_core == i[0])
				n_c = numpy.count_nonzero(P == i[0])
				lapace = CaculateLapace(n_c, n_total, k)

				#get location rule
				loc = numpy.where(array_core == i[0])
				row = loc[0][0] 
				col = loc[1][0]	
				L =  numpy.append(L,[[row, col, lapace]], axis=0)

			PN = GenneratePN(ATT, P, N)				
			A = CaculateA(ATT, PN, WP, WN)	
			# WP = numpy.sum(P[:,-1].astype(numpy.float))
			# WN = numpy.sum(N[:,-1].astype(numpy.float))
			WP = numpy.sum(P[:,-1])
			WN = numpy.sum(N[:,-1])

	L = numpy.delete(L, 0, axis=0)
	L = numpy.unique(L, axis=0)

	name_cols = df.columns.values
	names = []
	val = []
	clas  = [] 
	Lap = []

	for l in L :
		if l[2] > 50 : 
			names.append(name_cols[l[1].astype(int)])
			val.append(array[l[0].astype(int), l[1].astype(int)])
			clas.append(array[l[0].astype(int), -1])
			Lap.append(round(l[2],2))		
	# create dataframe
	d = {
		'Name': names,
		'Value': val,
		'Class': clas,
		'Laplace': Lap
	}

	# df = pandas.DataFrame(d,columns=['Name','Value','Class','Lapace'])
	df = pandas.DataFrame(d)
	return df

def main_cli():	

	# write file to excel
	args = parsers_in()
	# Create a workbook
	workbook = xlsxwriter.Workbook(args.output_file)
	worksheet = workbook.add_worksheet()
	workbook.close()
	
	# write to new file excel above
	df = specifyPN()
	writer = pandas.ExcelWriter(args.output_file)
	df.to_excel(writer,'Sheet1', index = False)
	writer.save()

if __name__ == '__main__':
	main_cli()	
	print('Conversion complete!')