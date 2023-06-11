function calcToGrade(quartersystem = false, points){
    if(!quartersystem) {
        return (17 - points)/3;
    }
    switch(points){
        case 15:
            return 0.75;
        case 14:
            return 1;
        case 13:
            return 1.25;
        case 12:
            return 1.75;
        case 11:
            return 2;
        case 10:
            return 2.25;
        case 9:
            return 2.75;
        case 8:
            return 3;
        case 7:
            return 3.25;
        case 6:
            return 3.75;
        case 5:
            return 4;
        case 4:
            return 4.25;
        case 3:
            return 4.75;
        case 2:
            return 5;
        case 1:
            return 5.25;
        case 0:
            return 6;
    }
}

function calcToPoints(quartersystem = false, grade) {
    if (!quartersystem) {
        return 17 - (grade * 3);
    }
    var num;
    if (grade == 5.75 || grade == 6) num = 0;
    else {
        if (String(grade).includes('.25')) grade = grade - 0.25 + 1 / 3;
        if (String(grade).includes('.75')) grade = grade + 0.25 - 1 / 3;
        num = calcToPoints(false, grade);
    }
    return Math.round(num * 4) / 4;
}
