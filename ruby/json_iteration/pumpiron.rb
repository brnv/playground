require 'json'
require 'fileutils'
require 'open-uri'

exercises = JSON.parse(File.read('exercises.json'))

index = 1

FileUtils.mkpath('output')

#@TODO: refactor someday
exercises.each do |exercise|
    targetDir = 'output/' + String(index) + "/"

    nameFile = targetDir + String(index) + "_name.txt"
    rulesFile = targetDir + String(index) + "_rules.txt"
    inventoryFile = targetDir + String(index) + "_i.txt"
    musclesAdditionalFile= targetDir + String(index) + "_ma.txt"
    musclesPrimaryFile= targetDir + String(index) + "_mp.txt"
    musclesGroupFile= targetDir + String(index) + "_m.txt"
    tipsFile= targetDir + String(index) + "_t.txt"

    FileUtils.mkpath(targetDir)
    FileUtils.touch(nameFile)
    FileUtils.touch(rulesFile)
    FileUtils.touch(inventoryFile)
    FileUtils.touch(musclesAdditionalFile)
    FileUtils.touch(musclesPrimaryFile)
    FileUtils.touch(musclesGroupFile)

    File.write(nameFile, exercise['name'][0])

    exercise['rules'].each do |rule|
        open(rulesFile, 'a') do |file|
          file << rule + "\n"
        end
    end

    imageIndex = 1

    exercise['images'].each do |image|
        targetFile = targetDir + String(index) + "_" + String(imageIndex) + '.jpg'

        open(targetFile, 'wb') do |file|
          file << open(image).read
        end

        imageIndex += 1
    end

    exercise['inventory'].each do |item|
        open(inventoryFile, 'a') do |file|
          file << item + "\n"
        end
    end

    exercise['muscles_additional'].each do |item|
        open(musclesAdditionalFile, 'a') do |file|
          file << item + "\n"
        end
    end

    exercise['muscles_primary'].each do |item|
        open(musclesPrimaryFile, 'a') do |file|
          file << item + "\n"
        end
    end

    exercise['muscles_group'].each do |item|
        open(musclesGroupFile, 'a') do |file|
          file << item + "\n"
        end
    end

    exercise['tips'].each do |item|
        open(tipsFile, 'a') do |file|
          file << item + "\n"
        end
    end

    index += 1
end
