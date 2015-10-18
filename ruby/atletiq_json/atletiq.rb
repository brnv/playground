require 'json'
require 'fileutils'
require 'open-uri'

exercises = JSON.parse(File.read('atletiq.json'))

index = 326

FileUtils.mkpath('output')

exercises.each do |exercise|
    targetDir = 'output/' + String(index) + "/"

    nameFile = targetDir + String(index) + "_name.txt"
    rulesFile = targetDir + String(index) + "_rules.txt"

    musclesGroupFile= targetDir + String(index) + "_m.txt"
    musclesPrimaryFile= targetDir + String(index) + "_mp.txt"
    musclesAdditionalFile= targetDir + String(index) + "_ma.txt"

    tipsFile= targetDir + String(index) + "_t.txt"
    inventoryFile = targetDir + String(index) + "_i.txt"

    FileUtils.mkpath(targetDir)

    FileUtils.touch(nameFile)
    FileUtils.touch(rulesFile)

    FileUtils.touch(musclesGroupFile)
    FileUtils.touch(musclesPrimaryFile)
    FileUtils.touch(musclesAdditionalFile)

    FileUtils.touch(tipsFile)
    FileUtils.touch(inventoryFile)

    File.write(nameFile, exercise['name'])

    exercise['rules'].each do |rule|
        open(rulesFile, 'a') do |file|
            file << rule + "\n"
        end
    end

    files = ['1m', '2m', '1w', '2w']
    files.each do |image|
        targetFile = targetDir + String(index) + "_" + image + '.jpg'
        open(targetFile, 'wb') do |file|
            file << open(exercise[image]).read
        end
    end

    exercise['ma'].each do |item|
        open(musclesAdditionalFile, 'a') do |file|
            file << item + "\n"
        end
    end

    exercise['mp'].each do |item|
        open(musclesPrimaryFile, 'a') do |file|
            file << item + "\n"
        end
    end

    open(musclesGroupFile, 'a') do |file|
        file << exercise['m']
    end

    index += 1
end
