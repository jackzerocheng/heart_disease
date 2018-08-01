from numpy import *
from math import *
from array import *
import matplotlib.pyplot as plt

#***读取数据
#前13列为特征，最后一列为类别
def loadDataSet():
    #训练数据
    dataMat = []
    #类别标签
    labelMat = []
    fr = open('../Data/download.txt')#读文件
    #按行读取文件内容
    for line in fr.readlines():
        lineArr = line.split(',')#每一行数据
        #为计算方便，增加一列特征x0=1,其系数为w0
        #线性回归h(x)=w0*1+w1*x1+w2*x2=(w0,w1,w2)*(1,x1,x2)
        #(w0,w1,w2)为所求回归系数
        #将(1,x1,x2)写入到dataMat[]中
        dataMat.append([float(lineArr[0]), float(lineArr[1]),float(lineArr[2]),
                        float(lineArr[3]),float(lineArr[4]),float(lineArr[5]),
                        float(lineArr[6]),float(lineArr[7]),float(lineArr[8]),
                        float(lineArr[9]),float(lineArr[10]),float(lineArr[11]),
                        float(lineArr[12])])
        #类别标签
        labelMat.append(int(lineArr[13]))
    return dataMat,labelMat

#sigmoid函数(logistic函数)
def sigmoid(inX):
    return 1.0/(1+exp(-inX))

#***梯度上升
#输入：训练数据，类别标签
def gradAscent(dataMatIn, classLabels):
    #列表转成矩阵
    dataMatrix = mat(dataMatIn)
    print(dataMatIn)
    exit()
    #转成列向量矩阵
    labelMat = mat(classLabels).transpose()
    #训练数据个数m，特征维数n
    m,n = shape(dataMatrix)
    #迭代步长
    alpha = 0.001
    #循环次数，认为设定
    maxCycles = 500
    #回归系数列向量，每个特征对应一个回归系数
    weights = ones((n,1))
    #循环最大次数maxCycles
    for k in range(maxCycles):
        #预测值(乘法次数m*n次),列向量
        h = sigmoid(dataMatrix*weights)
        #预测误差，列向量
        error = (labelMat - h)
        #回归系数更新
        weights = weights + alpha * dataMatrix.transpose()* error
    return weights

#***绘图决策边界
#weights:求得的参数向量
#weights[0]对应着一个数值
def plotBestFit(weights):
    #读取数据
    dataMat,labelMat=loadDataSet()
        #list类型转成array类型
    dataArr = array(dataMat)
    #样本数
    n = shape(dataArr)[0]
    #坐标绘图坐标
    xcord1 = []; ycord1 = []
    xcord2 = []; ycord2 = []
    for i in range(n):
        #类别为1样本，x轴对应第一列特征，y轴对应第二列特征
        if int(labelMat[i])== 1:
            xcord1.append(dataArr[i,1]); ycord1.append(dataArr[i,2])
        #类别为0样本，x轴对应第一列特征，y轴对应第二列特征
        else:
            xcord2.append(dataArr[i,1]); ycord2.append(dataArr[i,2])
    fig = plt.figure()
    ax = fig.add_subplot(111)
    #类别为1样本，红色菱形
    ax.scatter(xcord1, ycord1, s=30, c='red', marker='s')
    #类别为0样本，绿色圆形
    ax.scatter(xcord2, ycord2, s=30, c='green')
    #x坐标轴的取值范围
    x = arange(-3.0, 3.0, 0.1)
    #决策边界0=w0*x0+w1*x1+w2*x2，即x2=(-w0-w1*x1)/w2
    #在绘图坐标系中，即为y=(-w0-w1*x)/w2
    y = (-weights[0]-weights[1]*x)/weights[2]
    ax.plot(x, y)
    plt.xlabel('X1'); plt.ylabel('X2');
    plt.show()

#***随机梯度上升法
#输入：训练数据，类别标签
def stocGradAscent0(dataMatrix, classLabels):
    #样本数m,特征维数n
    m,n = shape(dataMatrix)
    #迭代步长
    alpha = 0.01
    #回归系数有n个，初始化全为1
    weights = ones(n)#1 x n 的行向量
    #遍历每一条数据
    for i in range(m):
        #h为当前样本的预测值，只用一个样本更新（一个数值类型）
        h = sigmoid(sum(dataMatrix[i]*weights))
        #预测误差（数值类型）
        error = classLabels[i] - h
        #只选择当前样本进行回归系数的更新
        weights = weights + alpha * error * dataMatrix[i]
    return weights

#***改进的随机梯度上升法
#输入：训练数据，类别标签，默认迭代次数150
def stocGradAscent1(dataMatrix, classLabels, numIter=150):
    #训练样本个数m,特征维数n
    m,n = shape(dataMatrix)
    #回归系数，1 x n行向量，n个特征对应n个回归系数
    #初始化为1
    weights = ones(n)
    #迭代numIter次
    for j in range(numIter):
        #产生0~m-1共m个整数值
        dataIndex = range(m)
        #遍历每个样本
        for i in range(m):
            #更新步长
            alpha = 4/(1.0+j+i)+0.0001
            #随机抽取一个样本
            randIndex = int(random.uniform(0,len(dataIndex)))
            #模型预测值(数值)
            h = sigmoid(sum(dataMatrix[randIndex]*weights))
            #预测误差
            error = classLabels[randIndex] - h
            #更新回归系数
            weights = weights + alpha * error * dataMatrix[randIndex]
            #被抽取的样本用于更新回归系数后，被剔除
            del(dataIndex[randIndex])
    return weights

#***分类函数
#输入：待分类的数据inX,更新好的回归系数
def classifyVector(inX, weights):
    #使用sigmoid函数预测
    prob1=inX*weights
    print('prob1=',prob1)
    prob2=sum(inX*weights)
    print('prob2=',prob2)

    prob = sigmoid(sum(inX*weights))
    #概率大于0.5判为第1类，概率小于0.5判为第0类
    if prob > 0.5: return 1.0
    else: return 0.0

#测试
def colicTest():
    #读训练数据
    frTrain = open('horseColicTraining.txt'); frTest = open('horseColicTest.txt')
    trainingSet = []; trainingLabels = []
    for line in frTrain.readlines():
        currLine = line.strip().split('\t')
        lineArr =[]
        for i in range(21):
            lineArr.append(float(currLine[i]))
        trainingSet.append(lineArr)
        trainingLabels.append(float(currLine[21]))
    #利用改进的梯度下降法获取回归系数
    trainWeights = stocGradAscent1(array(trainingSet), trainingLabels, 1000)
    #测试样本的预测错误数
    errorCount = 0;
    #存测试样本个数
    numTestVec = 0.0
    #读取每个测试数据，预测类别，并判断是否正确
    for line in frTest.readlines():
        #统计测试数据个数
        numTestVec += 1.0
        currLine = line.strip().split('\t')
        #每次存一个测试样本
        lineArr =[]
        #待测试的一个样本（不含标签）
        for i in range(21):
            lineArr.append(float(currLine[i]))
        #预测标签，判断是否预测正确
        if int(classifyVector(array(lineArr), trainWeights))!= int(currLine[21]):
            #统计预测错误的个数
            errorCount += 1
    #计算错误率
    errorRate = (float(errorCount)/numTestVec)
    print("the error rate of this test is: %f" % errorRate)
    return errorRate

#多次运行取平均
def multiTest():
    numTests = 10; errorSum=0.0
    #统计10次测试， 取平均错误率
    for k in range(numTests):
        errorSum += colicTest()
    print("after %d iterations the average error rate is: %f" % (numTests, errorSum/float(numTests)))

#运行main()函数
if __name__ == "__main__":
#   批处理梯度上升法
    #获取数据
#    dataArr,labelMat=loadDataSet()

#    #求参数
#    weights=gradAscent(dataArr,labelMat)
    #print('weights=')
    #print(weights)
#    #画图前需要把weights的matrix类型转换成array类型用matrix.getA()
#   plotBestFit(weights.getA())

##  #***随机梯度上升法
##  #获取数据list类型
     dataArr,labelMat=loadDataSet()
##  #求参数,把dataArr先由list类型转换成array类型
     weights=stocGradAscent0(array(dataArr),labelMat)
     print('weights=')
     print(weights)
     plotBestFit(weights)

     multiTest()