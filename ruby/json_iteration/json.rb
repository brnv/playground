require 'json'
require 'fileutils'
require 'open-uri'

imageBaseUrl = 'http://bodymaster.sportbox.ru/'

exercises = JSON.parse(File.read('exercises.json'))

index = 1

FileUtils.mkpath('output')

exercises.each do |exercise|
    targetDir = 'output/' + String(index) + "/"
    nameFile = targetDir + String(index) + "_name.txt"
    rulesFile = targetDir + String(index) + "_rules.txt"

    FileUtils.mkpath(targetDir)
    FileUtils.touch(nameFile)
    FileUtils.touch(rulesFile)

    File.write(nameFile, exercise['title'])
    File.write(rulesFile, exercise['description'])

    imageIndex = 1

    exercise['images'].each do |image|
        targetFile = targetDir + String(imageIndex) + '.jpg'

        open(targetFile, 'wb') do |file|
          file << open(imageBaseUrl + image).read
        end

        puts targetFile + " " + imageBaseUrl + image

        imageIndex += 1
    end

    index += 1
end
