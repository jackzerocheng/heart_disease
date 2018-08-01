from numpy import *
from math import *
import matplotlib.pyplot as plt

#  读取数据
#  $keys = [0'age',1'sex',2'cp',3'trestbps',4'chol',5'fbs',6'restecg',
#     7'thalach',8'exang',9'oldpeak',10'slop',11'ca',12'thal',13'status'];
def loadDataSet():
    #训练数据
    dataMat = []
    #类别标签
    labelMat = []
    fr = open('../Data/train_data.txt')#读文件

    max = getMax()
    min = getMin()

    #按行读取文件内容
    for line in fr.readlines():
        lineArr = line.split(',')#每一行数据

        #  数据归一化
        #   result=(val-min)/(max-min)
        #  status 不做处理
        for i in range(len(lineArr) - 1):
            tmpMax = float(max[i])
            tmpMin = float(min[i])
            try:
                lineArr[i] = (float(lineArr[i]) - tmpMin) / (tmpMax - tmpMin)
            except:
                lineArr[i] = 0

        #为计算方便，增加一列特征x0=1,其系数为w0
        #线性回归h(x)=w0*1+w1*x1+w2*x2 .....=(w0,w1,w2)*(1,x1,x2) ......
        #(w0,w1,w2)为所求回归系数
        #将(1,x1,x2)写入到dataMat[]中
        dataMat.append([float(lineArr[0]), float(lineArr[1]),float(lineArr[2]),
                        float(lineArr[3]),float(lineArr[4]),float(lineArr[5]),
                        float(lineArr[6]),float(lineArr[7]),float(lineArr[8]),
                        float(lineArr[9]),float(lineArr[10]),float(lineArr[11]),
                        float(lineArr[12])])

        #dataMat.append([float(lineArr[0]),
        #                float(lineArr[3]), float(lineArr[4]),
        #                float(lineArr[6]), float(lineArr[7]),
        #                float(lineArr[9]), float(lineArr[10]), float(lineArr[11]),
        #                float(lineArr[12])])
        #类别标签
        if(int(lineArr[13]) > 0):
            lineArr[13] = 1
        else:
            lineArr[13] = 0
        labelMat.append(int(lineArr[13]))
    return dataMat,labelMat

#  获取特征数值中各个最小值，严格按照字段顺序排列
def getMin():
    fr = open('../Data/key_train_min.txt')
    result = fr.read().split(',')
    return result

#   获取排序
def getMax():
    fr = open('../Data/key_train_max.txt')
    result = fr.read().split(',')
    return result

def getTestMax():
    fr = open('../Data/key_test_max.txt')
    result = fr.read().split(',')
    return result

def getTestMin():
    fr = open('../Data/key_test_min.txt')
    result = fr.read().split(',')
    return result

# sigmoid函数(logistic函数)
def sigmoid(inX):
    return 1.0/(1+exp(-inX))

#***批处理梯度上升
#输入：训练数据，类别标签
def gradAscent(dataMatIn, classLabels):
    #列表转成矩阵
    dataMatrix = mat(dataMatIn)
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
        h = dataMatrix * weights
        for j in range(m):
            try:
                h[j][0] = sigmoid(h[j][0])
            except:
                print('system error -----')
                print(j)
                print(h[j][0])
        #预测值(乘法次数m*n次),列向量
        #h = sigmoid(dataMatrix*weights)
        #预测误差，列向量
        error = (labelMat - h)
        #回归系数更新
        weights = weights + alpha * dataMatrix.transpose()* error
    return weights

#***随机梯度上升法
#输入：训练数据，类别标签
def stocGradAscent0(dataMatrix, classLabels):
    #样本数m,特征维数n
    m,n = shape(dataMatrix)
    #迭代步长
    alpha = 0.00075
    #回归系数有n个，初始化全为1
    weights = ones(n)#1 x n 的行向量
    #遍历每一条数据
    for i in range(m):
        #h为当前样本的预测值，只用一个样本更新（一个数值类型）
        h = sigmoid(sum(dataMatrix[i]*weights) / 13)
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
        dataIndex = list(range(m))
        #遍历每个样本
        for i in range(m):
            #更新步长
            alpha = 4/(1.0+j+i)+0.0001
            #随机抽取一个样本
            randIndex = int(random.uniform(0,len(dataIndex)))
            #模型预测值(数值)
            tmp = sum(dataMatrix[randIndex]*weights)
            h = sigmoid(tmp)
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
    #print('prob1=',prob1)
    prob2=sum(inX*weights)
    #print('prob2=',prob2)

    prob = sigmoid(sum(inX*weights))
    print('prob=',prob)
    #概率大于0.5判为第1类，概率小于0.5判为第0类
    if prob > 0.5:
        return 1.0
    else:
        return 0.0


#测试
def colicTest(weight):
    #测试数据
    frTest = open('../Data/train_data.txt')

    #   改进的随机梯度上升算法获取的权重
    trainWeights = weight
    #测试样本的预测错误数
    errorCount = 0;
    #存测试样本个数
    numTestVec = 0.0
    #读取每个测试数据，预测类别，并判断是否正确
    for line in frTest.readlines():
        #统计测试数据个数
        numTestVec += 1.0
        currLine = line.strip().split(',')
        #print(currLine);exit()
        #  数据归一化
        #   result=(val-min)/(max-min)
        #  status 不做处理
        max = getMax()
        min = getMin()
        for i in range(len(currLine) - 1):
            tmpMax = float(max[i])
            tmpMin = float(min[i])
            try:
                currLine[i] = (float(currLine[i]) - tmpMin) / (tmpMax - tmpMin)
            except:
                currLine[i] = 0


        if (int(currLine[13]) > 0):
            currLine[13] = 1
        else:
            currLine[13] = 0
        #每次存一个测试样本
        lineArr =[]
        #待测试的一个样本（不含标签）
        for i in range(len(currLine)-1):
            lineArr.append(float(currLine[i]))

        #lineArr.append([float(currLine[0]),
        #                float(currLine[3]), float(currLine[4]),
        #                float(currLine[6]), float(currLine[7]),
        #                float(currLine[9]), float(currLine[10]), float(currLine[11]),
        #                float(currLine[12])])



        #预测标签，判断是否预测正确
        if int(classifyVector(array(lineArr), trainWeights))!= int(currLine[13]):
            print('正确结果为',currLine[13])
            #统计预测错误的个数
            errorCount += 1
    #计算错误率
    errorRate = (float(errorCount)/numTestVec)
    print("the error rate of this test is: %f" % errorRate)
    return errorRate

#多次运行取平均
def multiTest(weight):
    numTests = 10; errorSum=0.0
    #统计10次测试， 取平均错误率
    for k in range(numTests):
        errorSum += colicTest(weight)
    print("after %d iterations the average right rate is: %f" % (numTests,1 - errorSum/float(numTests)))


if __name__ == "__main__":
    '''
#   批处理梯度上升法
正确率    60% +
    #获取数据
    dataArr,labelMat=loadDataSet()
    print('dataArr=')
    print(dataArr)
    print('labelMat=')
    print(labelMat)

#    #求参数
    weights=gradAscent(dataArr,labelMat)
    print('逻辑回归输出=')
    print(weights)
    '''
    #    梯度上升法
    #  正确率   70%



    ##  #***随机梯度上升法
    ##  #获取数据list类型
    #   正确率   80%+
    dataArr, labelMat = loadDataSet()
    print('dataArr==========',dataArr)
    print('labelMat=========',labelMat)
    ##  #求参数,把dataArr先由list类型转换成array类型
    #weights = stocGradAscent0(array(dataArr), labelMat)
    weights = stocGradAscent1(array(dataArr),labelMat,300)
    print('weights=======',weights)
    print('------------权重计算完毕----------------')
    #plotBestFit(weights)

    multiTest(weights)